<?php
    // Más seguro que hacer include ya que si no está cargado el archivo, detiene la ejecución 
    // __DIR__ da la ruta absoluta del directorio actual
    require_once __DIR__ . "/../baseDatos.php";

    class PortadaModelo {
        public static function getPeliculas(): array {
            $conex = BaseDatos::getConexion();

            $sql = "SELECT * FROM pelicula NATURAL JOIN imagenes WHERE pelicula.id = imagenes.id_pelicula";
            $result = $conex->query($sql);
            $peliculas = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];

                    if(strpos(strtolower($row["ruta"]), "webp") == false) {
                        if(!isset($peliculas[$id])) {
                            $peliculas[$id] = array(
                                "id" => $row["id"],
                                "titulo" => $row["titulo"],
                                "ruta" => $row["ruta"]
                            );
                        }
                    }
                }
            }

            BaseDatos::cerrarConexion();
            return array_values($peliculas); 
        }
    }
?>