<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // verifica el estado de la conexión
    $usuarioLog = isset($_SESSION['usuarioAct']) ? $_SESSION['usuarioAct'] : '';
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';
    $idPeli = isset($_GET["idPeli"]) ? $_GET["idPeli"] : 
                    (isset($_POST["idPeli"]) ? $_POST["idPeli"] : '');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $hashtag = isset($_POST["hashtag"]) ? $_POST["hashtag"] : '';

        PeliculaModelo::agregarHashtag($idPeli, $hashtag);
        header("Location: pelicula.php?idPeli=$idPeli");
        exit();
    }

    echo $twig->render('agregar_hashtag.html', [
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol,
        'idPeli' => $idPeli
    ]);
?>