<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/loginMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // verifica el estado de la conexión
    $usuarioLog = isset($_SESSION['usuarioAct']) ? $_SESSION['usuarioAct'] : '';
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';
    $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : '';

    $listUsuarios = LoginModelo::getAllUsuarios();

    echo $twig->render('listar_usuarios.html', [
        'usuarios' => $listUsuarios,
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol,
        'idUsuario' => $idUsuario,
    ]);
?>