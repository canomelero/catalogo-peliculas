<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/peliculaMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // verifica el estado de la conexión
    $usuarioLog = isset($_SESSION['usuarioAct']) ? $_SESSION['usuarioAct'] : '';
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';
    $mensaje = "";
    $img = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : '';
        $director = isset($_POST["director"]) ? $_POST["director"] : '';
        $actores = isset($_POST["actores"]) ? $_POST["actores"] : '';
        $genero = isset($_POST["genero"]) ? $_POST["genero"] : '';
        $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : '';
        $fecha = isset($_POST["fecha-peli"]) ? $_POST["fecha-peli"] : '';
        $dt = DateTime::createFromFormat('Y-m-d', $fecha);   // Para validar que la fecha es correcta
        $hashtag = isset($_POST["hashtag"]) ? $_POST["hashtag"] : '';

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['imagen']['tmp_name'];  // Guarda la ruta del archivo temporal
            $file_name = basename($_FILES['imagen']['name']);   // Obtiene el nombre del archivo
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));   // Se obtiene la extensión

            $allowed_exts = ["jpg", "jpeg", "png"];
            $max_size = 2 * 1024 * 1024; // 2 MB

            // Si la extensión no está en la lista, se genera un mensaje de error
            if (!in_array($file_ext, $allowed_exts)) {
                $mensaje = "Extensión no permitida. Usa jpg, jpeg o png.";
            } 
            elseif ($_FILES['imagen']['size'] > $max_size) {    // Si excede de tamaño, genera un mensaje de error
                $mensaje = "Tamaño de archivo demasiado grande (máx 2MB).";
            } 
            else {
                // Se obtiene la ruta absoluta y se genera un identificador único que comienza con peli_
                // de manera que cada imagen se guarda en la base de datos con un identificador distinto
                // y se evita que la imagen pueda sobreescribirse (varios usuarios suben img con mismo nombre)
                $upload_dir = __DIR__ . "/img/";
                $new_name = uniqid("peli_") . "." . $file_ext;
                $destination = $upload_dir . $new_name;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $img = "img/" . $new_name;
                } 
                else {
                    $mensaje = "Error al guardar la imagen.";
                }
            }
        } 
        else if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] != UPLOAD_ERR_NO_FILE) {
            $mensaje = "Error en la subida: código " . $_FILES['imagen']['error'];
        }

        // Si no se ha podido crear el objeto porque la fecha dada y el formato puesto no coinciden, devuelve false
        // Format te devuelve la fecha con el formato indicado y si compara con la fecha del post
        if($dt === false || $dt->format('Y-m-d') != $fecha) {
          $mensaje = "Fecha no válida";
        }
        else if(!empty($titulo) && !empty($director) && !empty($actores) && !empty($genero) && !empty($descripcion) &&
            !empty($fecha) && !empty($img) && !empty($hashtag)) {
            PeliculaModelo::agregarPeli($titulo, $director, $actores, $genero, 
                                        $descripcion, $fecha, $img, $hashtag);
            header("Location: portada.php");
            exit();    
        }
    }

    echo $twig->render('agregar_peli.html', [
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol,
        'mensaje' => $mensaje
    ]);
?>