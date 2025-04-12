<?php
    // Más seguro que hacer include ya que si no está cargado el archivo, detiene la ejecución 
    // __DIR__ da la ruta absoluta del directorio actual
    require_once __DIR__ . "/../baseDatos.php";

    class PeliculaModelo {
        public static function getPelicula($idPelicula): array {
            $conex = BaseDatos::getConexion();

            // Se hace una consulta segura con una sentencia preparada, insertando un valor más tarde en ?
            // stmt es un objeto de tipo mysql_stmt que representa una sentencia preparada
            $stmt = $conex->prepare("SELECT * FROM pelicula WHERE id = ?");

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
                    "descripcion" => $row["descripcion"]
                );
            }
            
            $conex->close();
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
                    // en este caso será png, para diferenciar la imagen de la portada y que no la cargue
                    if(strpos(strtolower($row["ruta"]), "png") == false) {
                        $imgs[] = array(
                            "ruta" => $row["ruta"]
                        );
                    }
                }
            }

            $conex->close();
            return $imgs;
        }

        public static function getComentarios($idPelicula) : string {
            $conex = BaseDatos::getConexion();

            $stmt = $conex->prepare("SELECT * FROM comentarios WHERE id_pelicula = ?");
            $stmt->bind_param("i", $idPelicula);
            $stmt->execute();
            $result = $stmt->get_result();

            $comentarios = [];

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Se añade el comentario al array de comentarios
                    $comentarios[] = array(
                        "autor" => $row["autor"],
                        "comentario" => $row["comentario"]
                    );
                }

                // Se pasa el array de comentarios a un archivo JSON para poder manejarlo en JavaScript
                $comentJSON = json_encode($comentarios, JSON_PRETTY_PRINT);
            }

            $stmt->close();
            $conex->close();
            return $comentJSON;
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

            $conex->close();
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
            $conex->close();
        }
    }
?>