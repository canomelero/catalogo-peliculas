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
        $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : '';
        $genero = isset($_POST["genero"]) ? $_POST["genero"] : '';
        $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : '';
        $fecha = isset($_POST["fecha-peli"]) ? $_POST["fecha-peli"] : '';
        $img = isset($_POST["img-port"]) ? $_POST["img-port"] : '';
        $hashtag = isset($_POST["hashtag"]) ? $_POST["hashtag"] : '';

        if(!empty($titulo) && !empty($genero) && !empty($descripcion) && !empty($fecha) && !empty($img) && !empty($hashtag)) {
            PeliculaModelo::editarPeli($idPeli, $titulo, $genero, $descripcion, $fecha, 
                                        $img, $hashtag);
            header("Location: pelicula.php?idPeli=$idPeli");
            exit();    
        }
    }

    echo $twig->render('editar_peli.html', [
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol,
        'idPeli' => $idPeli
    ]);
?>