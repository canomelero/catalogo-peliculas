<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $idComent = isset($_GET["idComent"]) ? $_GET["idComent"] : 
                    (isset($_POST["idComent"]) ? $_POST["idComent"] : '');
    $idPeli = isset($_GET["idPeli"]) ? $_GET["idPeli"] : 
                    (isset($_POST["idPeli"]) ? $_POST["idPeli"] : '');
    $mensaje = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $coment = isset($_POST["txtComent"]) ? $_POST["txtComent"] : '';

        if(!empty($coment) && !empty($idComent)) {
            PeliculaModelo::actualizarComentario($coment, $idComent);
            header("Location: pelicula.php?idPeli=$idPeli");
            exit();
        }
    }

    echo $twig->render('modificar_coment.html', [
        "idComent" => $idComent,
        "idPeli" => $idPeli
    ]);
?>