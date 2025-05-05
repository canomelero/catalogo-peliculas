<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // verifica el estado de la conexión
    $usuarioLog = isset($_SESSION['usuarioAct']) ? $_SESSION['usuarioAct'] : '';
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';
    
    // Se obtiene la información de la película y sus imagenes
    $idPelicula = (int) $_GET["id"];
    $pelicula = PeliculaModelo::getPelicula($idPelicula);
    $imgs = PeliculaModelo::getImagenes($idPelicula);

    echo $twig->render('pelicula_imprimir.html', [
        'pelicula' => $pelicula,
        'imgs' => $imgs,
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol
    ]);
?>