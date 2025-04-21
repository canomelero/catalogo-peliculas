<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    // Se obtiene la información de la película y sus imagenes
    $idPelicula = (int) $_GET["id"];
    $pelicula = PeliculaModelo::getPelicula($idPelicula);
    $imgs = PeliculaModelo::getImagenes($idPelicula);

    // Si hay algún dato de la película que es null, se redirige a una página con error 400
    if($pelicula == [] || $imgs == []) {
        http_response_code(404);
        echo "Error 404: falta información de la película en la Base de Datos";
        exit();
    }

    echo $twig->render('pelicula_imprimir.html', [
        'pelicula' => $pelicula,
        'imgs' => $imgs
    ]);
?>