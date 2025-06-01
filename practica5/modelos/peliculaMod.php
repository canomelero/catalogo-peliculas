<?php
    // Más seguro que hacer include ya que si no está cargado el archivo, detiene la ejecución 
    // __DIR__ da la ruta absoluta del directorio actual
    require_once __DIR__ . "/../baseDatos.php";

    class PeliculaModelo {
        public static function getPelicula($idPelicula): array {
            $conex = BaseDatos::getConexion();

            // Se hace una consulta segura con una sentencia preparada, insertando un valor más tarde en ?
            // stmt es un objeto de tipo mysql_stmt que representa una sentencia preparada
            $stmt = $conex->prepare("SELECT *, DATE_FORMAT(fecha, '%d-%m-%y') AS fecha_formateada
                                        FROM pelicula WHERE id = ?");

            // i -> parámetro entero; $idPelicula -> lo que sustituirá a ?
            $stmt->bind_param("i", $idPelicula);   
            $stmt->execute();
            $result = $stmt->get_result();

            $pelicula = [];

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pelicula = array(
                    "id" => $row["id"],
                    "titulo" => $row["titulo"],
                    "director" => $row["director"],
                    "actores" => $row["actores"],
                    "genero" => $row["genero"],
                    "descripcion" => $row["descripcion"],
                    "fecha" => $row["fecha_formateada"]
                );
            }
            else {
                $pelicula = [];
            }
            
            return $pelicula;
        }

        public static function getImagenes($idPelicula): array {
            $conex = BaseDatos::getConexion();

            $stmt = $conex->prepare("SELECT * FROM imagenes WHERE id_pelicula = ?");
            $stmt->bind_param("i", $idPelicula);
            $stmt->execute();
            $result = $stmt->get_result();

            $imgs = [];

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // strpos sirve para comprobar si en una cadena se encuentra una cadena
                    // Se utiliza para descartar una de las rutas y que no cargue esa img
                    if(strpos(strtolower($row["ruta"]), "interstellar.png") == false) {
                        $imgs[] = array(
                            "ruta" => $row["ruta"]
                        );
                    }
                }
            }
            else {
                $imgs = [];
            }

            return $imgs;
        }

        public static function getComentarios($idPelicula) : string {
            $conex = BaseDatos::getConexion();

            $stmt = $conex->prepare("SELECT * FROM comentarios WHERE id_pelicula = ? ORDER BY id DESC");
            $stmt->bind_param("i", $idPelicula);
            $stmt->execute();
            $result = $stmt->get_result();

            $comentarios = [];

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Se añade el comentario al array de comentarios
                    $comentarios[] = array(
                        "id" => $row["id"],
                        "id_peli" => $row["id_pelicula"],
                        "autor" => $row["autor"],
                        "fecha" => $row["fecha"],
                        "comentario" => $row["comentario"],
                        "email" => $row["email"],
                        "modificado" => $row["modificado"]
                    );
                }

                // Se pasa el array de comentarios a un archivo JSON para poder manejarlo en JavaScript
                $comentJSON = json_encode($comentarios, JSON_PRETTY_PRINT);
            }
            else {
                $comentJSON = "";
            }

            $stmt->close();
            return $comentJSON;
        }

        public static function getAllComents() : array {
            $conex = BaseDatos::getConexion();

            $result = $conex->query("SELECT * FROM comentarios");
            $comentarios = [];

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Se añade el comentario al array de comentarios
                    $comentarios[] = array(
                        "id" => $row["id"],
                        "id_peli" => $row["id_pelicula"],
                        "autor" => $row["autor"],
                        "fecha" => $row["fecha"],
                        "comentario" => $row["comentario"],
                        "email" => $row["email"],
                        "modificado" => $row["modificado"]
                    );
                }
            }
            else {
                $comentarios = [];
            }

            return $comentarios;
        }

        public static function getPalabrasProh() : string {
            $conex = BaseDatos::getConexion();

            $result = $conex->query("SELECT * FROM palabrasProh");
            $palabras = [];

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $palabras[] = array(
                        "palabra" => $row["palabra"]
                    );
                }

                $palabrasJSON = json_encode($palabras, JSON_PRETTY_PRINT);
            }

            BaseDatos::cerrarConexion();    // Como puede ser la última operación a realizar, se cierra la BD
            return $palabrasJSON;
        }

        public static function insertarComentario($autor, $email, $texto, $idPelicula) {
            $conex = BaseDatos::getConexion();

            // Se previene las inyecciones SQL con prepare
            $stmt = $conex->prepare("INSERT INTO comentarios (autor, email, comentario, id_pelicula)
                                        VALUES (?, ?, ?, ?)");

            // Los tipos de datos a escribir van a ser string, string, string e int (sssi)
            $stmt->bind_param("sssi", $autor, $email, $texto, $idPelicula);
            $stmt->execute();
            
            $stmt->close();
            BaseDatos::cerrarConexion();    // Como puede ser la última operación a realizar, se cierra la BD
        }

        public static function actualizarComentario($textoComentario, $id) {
            $conex = BaseDatos::getConexion();

            $stmt = $conex->prepare("UPDATE comentarios SET modificado = 'S', comentario = ? WHERE id = ?");
            $stmt->bind_param("si", $textoComentario, $id);
            $stmt->execute();
            
            $stmt->close();
            BaseDatos::cerrarConexion();
        }

        public static function eliminarComentario($idComent) {
            $conex = BaseDatos::getConexion();

            $stmt = $conex->prepare("DELETE FROM comentarios WHERE id = ?");
            $stmt->bind_param("i", $idComent);
            $stmt->execute();
            
            $stmt->close();
            BaseDatos::cerrarConexion();
        }

        public static function agregarPeli($titulo, $director, $actores, $genero, $descripcion, $fecha, $img, $hashtag) {
            $conex = BaseDatos::getConexion();

            // Se inserta la película en la tabla
            $stmt = $conex->prepare("INSERT INTO pelicula(titulo, director, actores, genero, descripcion, fecha) 
                                        VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $titulo, $director, $actores, $genero, $descripcion, $fecha);
            $stmt->execute();
            $idPelicula = $conex->insert_id;    // Se obtiene el id generado de una inserción

            // Se inserta la imagen de la pelicula en la tabla
            $stmt = $conex->prepare("INSERT INTO imagenes(id_pelicula, ruta) VALUES (?, ?)");
            $stmt->bind_param("is", $idPelicula, $img);
            $stmt->execute();

            // Verificar si el hashtag ya existe
            $stmt = $conex->prepare("SELECT id_hashtag FROM hashtags WHERE hashtag = ?");
            $stmt->bind_param("s", $hashtag);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Si el hashtag ya existe, se obtiene el id
                $row = $result->fetch_assoc();
                $idHashtag = $row['id_hashtag'];
            } else {
                // Insertar el nuevo hashtag
                $stmt = $conex->prepare("INSERT INTO hashtags(hashtag) VALUES (?)");
                $stmt->bind_param("s", $hashtag);
                $stmt->execute();
                $idHashtag = $conex->insert_id;
            }

            // Se inserta la tupla en la tabla pelicula_hashtag
            $stmt = $conex->prepare("INSERT INTO peliculas_hashtags(id_pelicula, id_hashtag) VALUES (?, ?)");
            $stmt->bind_param("ii", $idPelicula, $idHashtag);
            $stmt->execute();

            $stmt->close();
            BaseDatos::cerrarConexion();
        }

        public static function editarPeli($idPeli, $titulo, $genero, $descripcion, $hashtag){
            $conex = BaseDatos::getConexion();

            if($titulo != null && $titulo != "") {
                // Se actualiza el título
                $stmt = $conex->prepare("UPDATE pelicula SET titulo = ? WHERE id = ?");
                $stmt->bind_param("si", $titulo, $idPeli);
                $stmt->execute();
            }

            if($genero != null && $genero != "") {
                // Se actualiza el genero
                $stmt = $conex->prepare("UPDATE pelicula SET genero = ? WHERE id = ?");
                $stmt->bind_param("si", $genero, $idPeli);
                $stmt->execute();
            }

            if($descripcion != null && $descripcion != "") {
                // Se actualiza la descripción
                $stmt = $conex->prepare("UPDATE pelicula SET descripcion = ? WHERE id = ?");
                $stmt->bind_param("si", $descripcion, $idPeli);
                $stmt->execute();
            }

            if($hashtag != "") {
                // Se eliminan todos los hashtag asociadas a la película
                $stmt = $conex->prepare("DELETE FROM peliculas_hashtags WHERE id_pelicula = ?");
                $stmt->bind_param("i", $idPeli);
                $stmt->execute();
                
                // Se verifica si el hashtag ya existe
                $stmt = $conex->prepare("SELECT id_hashtag FROM hashtags WHERE hashtag = ?");
                $stmt->bind_param("s", $hashtag);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Si el hashtag ya existe, se obtiene el id
                    $row = $result->fetch_assoc();
                    $idHashtag = $row['id_hashtag'];
                } else {
                    // Insertar el nuevo hashtag
                    $stmt = $conex->prepare("INSERT INTO hashtags(hashtag) VALUES (?)");
                    $stmt->bind_param("s", $hashtag);
                    $stmt->execute();
                    $idHashtag = $conex->insert_id;
                }

                // Se añade a la película un nuevo hashtag
                $stmt = $conex->prepare("INSERT INTO peliculas_hashtags(id_pelicula, id_hashtag) VALUES (?, ?)");
                $stmt->bind_param("ii", $idPeli, $idHashtag);
                $stmt->execute();
            }

            $stmt->close();
        }

        public static function eliminarPelicula($idPeli) {
            $conex = BaseDatos::getConexion();

            // Se eliminan las imagenes de la película de la tabla imagenes
            $stmt = $conex->prepare("DELETE FROM imagenes WHERE id_pelicula = ?");
            $stmt->bind_param("i", $idPeli);
            $stmt->execute();

            // Se eliminan los hashtags asociados a esa película
            $stmt = $conex->prepare("DELETE FROM peliculas_hashtags WHERE id_pelicula = ?");
            $stmt->bind_param("i", $idPeli);
            $stmt->execute();

            // Se elimina la tupla de la tabla película con ese id
            $stmt = $conex->prepare("DELETE FROM pelicula WHERE id = ?");
            $stmt->bind_param("i", $idPeli);
            $stmt->execute();

            $stmt->close();
        }

        public static function getAllPeliculas() {
            $conex = BaseDatos::getConexion();

            // Se va uniendo la tabla de la izquierda con la tabla de la derecha en función del valor del id de la película
            $result = $conex->query(
                "SELECT p.*, 
                        i.ruta AS img_ruta, 
                        h.hashtag AS hashtag, 
                        DATE_FORMAT(p.fecha, '%d-%m-%y') AS fecha_formateada
                FROM pelicula p
                LEFT JOIN imagenes i ON p.id = i.id_pelicula
                LEFT JOIN peliculas_hashtags ph ON p.id = ph.id_pelicula
                LEFT JOIN hashtags h ON ph.id_hashtag = h.id_hashtag;"
            );

            $peliculas = [];

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Agrupar películas por ID para manejar múltiples imágenes y hashtags y que no haya valores repetidos
                    $id = $row["id"];

                    if (!isset($peliculas[$id])) {  // Se comprueba si el array contiene esa película
                        $peliculas[$id] = [
                            "id" => $row["id"],
                            "titulo" => $row["titulo"],
                            "director" => $row["director"],
                            "actores" => $row["actores"],
                            "genero" => $row["genero"],
                            "descripcion" => $row["descripcion"],
                            "fecha" => $row["fecha_formateada"],
                            "hashtags" => [],
                            "imgs" => []
                        ];
                    }

                    // Añadir imágenes y hashtags, evitando los valores duplicados
                    if (!empty($row["img_ruta"]) && !in_array($row["img_ruta"], $peliculas[$id]["imgs"])) {
                        // Se agrega al final del array de imgs, la ruta de la imagen actual
                        $peliculas[$id]["imgs"][] = $row["img_ruta"];
                    }

                    if (!empty($row["hashtag"]) && !in_array($row["hashtag"], $peliculas[$id]["hashtags"])) {
                        $peliculas[$id]["hashtags"][] = $row["hashtag"];
                    }
                }
            }

            // Se devuelve un array con índice numérico (0, 1, 2,...) y no el ID (1, 7, 20,...), obteniendo un array simple
            return array_values($peliculas); 
        }

        public static function agregarImg($idPeli, $img) {
            $conex = BaseDatos::getConexion();

            $stmt = $conex->prepare("INSERT INTO imagenes (id_pelicula, ruta) VALUES (?, ?)");
            $stmt->bind_param("is", $idPeli, $img);
            $stmt->execute();

            $stmt->close();
        }

        public static function agregarHashtag($idPeli, $hashtag) {
            $conex = BaseDatos::getConexion();

            // Se verifica si el hashtag ya existe
            $stmt = $conex->prepare("SELECT id_hashtag FROM hashtags WHERE hashtag = ?");
            $stmt->bind_param("s", $hashtag);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Si el hashtag ya existe, se obtiene el id
                $row = $result->fetch_assoc();
                $idHashtag = $row['id_hashtag'];
            } else {
                // Insertar el nuevo hashtag
                $stmt = $conex->prepare("INSERT INTO hashtags(hashtag) VALUES (?)");
                $stmt->bind_param("s", $hashtag);
                $stmt->execute();
                $idHashtag = $conex->insert_id;
            }

            // Se agrega a la tabla peliculas_hashtags
            $stmt = $conex->prepare("INSERT INTO peliculas_hashtags (id_pelicula, id_hashtag) VALUES (?, ?)");
            $stmt->bind_param("ii", $idPeli, $idHashtag);
            $stmt->execute();

            $stmt->close();
        }

        public static function getHashtags($idPelicula) {
            $conex = BaseDatos::getConexion();

            $stmt = $conex->prepare(
                "SELECT h.hashtag 
                        FROM hashtags h
                        LEFT JOIN peliculas_hashtags ph ON h.id_hashtag = ph.id_hashtag
                        WHERE ph.id_pelicula = ?;"
            );

            $stmt->bind_param("i", $idPelicula);
            $stmt->execute();
            $result = $stmt->get_result();

            $hashtags = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $hashtags[] = $row["hashtag"];
                }
            }

            $stmt->close();
            return $hashtags;
        }
    }
?>