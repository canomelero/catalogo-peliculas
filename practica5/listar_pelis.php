<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // verifica el estado de la conexión
    $usuarioLog = isset($_SESSION['usuarioAct']) ? $_SESSION['usuarioAct'] : '';
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';

    // Obtiene el tipo de archivo que se está enviando en la cabecera HTTP
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    // Busca si la cadena application/json está dentro de la cabecera de la petición
    $esJson = stripos($contentType, 'application/json') !== false;

    if($esJson) {
        $inputJSON = file_get_contents('php://input');  // Se lee el cuerpo de la petición
        $input = json_decode($inputJSON, true);     // Decodifica el json en un array asociativo
        $busqueda = strtolower($input['busqueda'] ?? '');   // Extrae el valor asociado al campo busqueda

        $peliculas = PeliculaModelo::getAllPeliculas();

        if(empty($busqueda)) {
            $filtradas = $peliculas;    // Devuelve todas si no hay filtro
        } 
        else {
            // Con array_filter se devuelve un array con los elementos que cumplen la información
            // Se busca para cada peli su titulo y se busca la posición donde aparece busqueda  
            // dentro de la variable titulo. Si encuentra una posicion, será true (al devolver algo distinto de false),
            // y si no encuentra nada devolverá false
            $filtradas = array_filter($peliculas, function ($peli) use ($busqueda) {
                $titulo = strtolower($peli['titulo'] ?? '');
                return stripos($titulo, $busqueda) !== false;
            });
        }

        echo $twig->render('tabla_pelis.html', [
            'peliculas' => $filtradas,
            'usuarioLog' => $usuarioLog,
            'rolUsuario' => $rol
        ]);

        exit;
    }

    $peliculas = PeliculaModelo::getAllPeliculas();

    echo $twig->render('listar_pelis.html', [
        'peliculas' => $peliculas,
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol
    ]);
?>