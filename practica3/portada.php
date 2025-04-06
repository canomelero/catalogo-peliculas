<?php
    require_once './vendor/autoload.php';

    $conex = new mysqli("localhost", "root", "", "sibw", "3306");

    try {
        $sql = "SELECT * FROM pelicula NATURAL JOIN imagenes WHERE pelicula.id = imagenes.id_pelicula";
        $result = $conex->query($sql);
        $peliculas = [];

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $peliculas[] = array(
                    "titulo" => $row["titulo"],
                    "ruta" => $row["ruta"]
                );
            }
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }

    $loader = new
    \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    echo $twig->render('portada.html', ['peliculas' => $peliculas]);
?>