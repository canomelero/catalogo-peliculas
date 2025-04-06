<?php
    require_once './vendor/autoload.php';

    $conex = new mysqli("localhost", "root", "", "sibw", "3306");

    try {
        $sql = "SELECT * FROM pelicula, comentarios WHERE pelicula.id = comentarios.id_pelicula";
        $result = $conex->query($sql);

        $pelicula = null;
        $comentarios = [];

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Para evitar que entre más veces y se sobreescriba el resultado
                if($pelicula == null) {     
                    $pelicula = array(
                        "titulo" => $row["titulo"],
                        "director" => $row["director"],
                        "actores" => $row["actores"],
                        "genero" => $row["genero"],
                        "descripcion" => $row["descripcion"]
                    );
                }

                // Se añade el comentario al array de comentarios
                $comentarios[] = array(
                    "autor" => $row["autor"],
                    "comentario" => $row["comentario"]
                );
            }

            // Se pasa el array de comentarios a un archivo JSON para poder manejarlo en JavaScript
            $comentJSON = json_encode($comentarios, JSON_PRETTY_PRINT);
        }

    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }

    $loader = new
    \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    echo $twig->render('pelicula.html', ['pelicula' => $pelicula, 'comentarios' => $comentJSON]);
?>