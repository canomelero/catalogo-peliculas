<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/portadaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $peliculas = PortadaModelo::getPeliculas(); 

    echo $twig->render('portada.html', ['peliculas' => $peliculas]);
?>