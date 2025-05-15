<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // verifica el estado de la conexión
    $usuarioLog = isset($_SESSION['usuarioAct']) ? $_SESSION['usuarioAct'] : '';
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';

    $listPelis = PeliculaModelo::getAllPeliculas();

    echo $twig->render('listar_pelis.html', [
        'peliculas' => $listPelis,
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol
    ]);
?>