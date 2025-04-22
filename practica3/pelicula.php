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

    // Si hay algún dato de la película que es null, se redirige a una página con error 400
    if($pelicula == [] || $imgs == [] || $comentarios == "") {
        http_response_code(404);    // Código de respuesta HTTP que se le devuelve al cliente
        echo "Error 404: falta información de la película en la Base de Datos";
        exit();
    }

    // Si la solicitud HTTP del cliente es POST, inserto el comentario en la BD
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $autor = isset($_POST["name"]) ? $_POST["name"] : '';
        $email = isset($_POST["email"]) ? $_POST["email"] : '';
        $textoComent = isset($_POST["txtComent"]) ? $_POST["txtComent"] : '';

        if (!empty($autor) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($textoComent)) {
            PeliculaModelo::insertarComentario($autor, $email, $textoComent, $idPelicula);
        
            // Redirige a la página actual para evitar que la página se recargue y reenvíe el formulario
            header("Location: " . $_SERVER["REQUEST_URI"]);
            exit();
        }
    }

    echo $twig->render('pelicula.html', [
        'pelicula' => $pelicula,
        'imgs' => $imgs,
        'comentarios' => $comentarios,
        'palabrasProh' => $palabrasProh
    ]);
?>