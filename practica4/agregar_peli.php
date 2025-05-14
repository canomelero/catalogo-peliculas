<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // verifica el estado de la conexión
    $usuarioLog = isset($_SESSION['usuarioAct']) ? $_SESSION['usuarioAct'] : '';
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : '';
        $director = isset($_POST["director"]) ? $_POST["director"] : '';
        $actores = isset($_POST["actores"]) ? $_POST["actores"] : '';
        $genero = isset($_POST["genero"]) ? $_POST["genero"] : '';
        $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : '';
        $fecha = isset($_POST["fecha-peli"]) ? $_POST["fecha-peli"] : '';
        $img = isset($_POST["img-port"]) ? $_POST["img-port"] : '';
        $hashtag = isset($_POST["hashtag"]) ? $_POST["hashtag"] : '';

        if(!empty($titulo) && !empty($director) && !empty($actores) && !empty($genero) && !empty($descripcion) &&
            !empty($fecha) && !empty($img) && !empty($hashtag)) {
            PeliculaModelo::agregarPeli($titulo, $director, $actores, $genero, 
                                        $descripcion, $fecha, $img, $hashtag);
            header("Location: portada.php");
            exit();    
        }
    }

    echo $twig->render('agregar_peli.html', [
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol
    ]);
?>