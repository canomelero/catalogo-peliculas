<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    // Indica al cliente que la respuesta va a ser un JSON
    header('Content-Type: application/json');

    try {
        // Se obtiene el body de la solicitud HTTP y se pasa a array 
        $input = json_decode(file_get_contents('php://input'), true);
        $idComent = isset($input["id"]) ? $input["id"] : '';
        PeliculaModelo::eliminarComentario($idComent);
        
        // Se devuelve una respuesta de éxito al cliente
        echo json_encode(["success" => true, "message" => "Comentario eliminado correctamente."]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>