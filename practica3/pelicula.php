<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $idPelicula = (int) $_GET['id']; // con int se asegura que el valor obtenido es un entero   
    $pelicula = PeliculaModelo::getPelicula($idPelicula);
    $imgs = PeliculaModelo::getImagenes($idPelicula);
    $comentarios = PeliculaModelo::getComentarios($idPelicula);
    $palabrasProh = PeliculaModelo::getPalabrasProh();

    echo $twig->render('pelicula.html', ['pelicula' => $pelicula, 'imgs' => $imgs, 
                        'comentarios' => $comentarios, 'palabrasProh' => $palabrasProh]);
?>