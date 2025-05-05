<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/portadaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // verifica el estado de la conexión
    $usuarioLog = isset($_SESSION['usuarioAct']) ? $_SESSION['usuarioAct'] : '';
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';

    $peliculas = PortadaModelo::getPeliculas(); 

    echo $twig->render('portada.html', [
        'peliculas' => $peliculas, 
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol
    ]);
?>