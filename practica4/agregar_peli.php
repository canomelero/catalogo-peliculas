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
            $file_tmp = $_FILES['imagen']['tmp_name'];
            $file_name = basename($_FILES['imagen']['name']);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_exts = ["jpg", "jpeg", "png"];
            $max_size = 2 * 1024 * 1024; // 2 MB

            if (!in_array($file_ext, $allowed_exts)) {
                $mensaje = "Extensión no permitida. Usa jpg, jpeg o png.";
            } elseif ($_FILES['imagen']['size'] > $max_size) {
                $mensaje = "Tamaño de archivo demasiado grande (máx 2MB).";
            } else {
                $upload_dir = __DIR__ . "/img/";
                $new_name = uniqid("peli_") . "." . $file_ext;
                $destination = $upload_dir . $new_name;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $img = "img/" . $new_name;
                } else {
                    $mensaje = "Error al guardar la imagen.";
                    $mensaje .= "<br>Temp file: $file_tmp";
                    $mensaje .= "<br>Destination: $destination";
                    $mensaje .= "<br>¿Existe carpeta?: " . (is_dir($upload_dir) ? 'Sí' : 'No');
                    $mensaje .= "<br>¿Es escribible?: " . (is_writable($upload_dir) ? 'Sí' : 'No');
                }
            }
        } else if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] != UPLOAD_ERR_NO_FILE) {
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
        else {
            if (empty($mensaje)) {
                $mensaje = "Todos los campos son obligatorios.";
            }
        }
    }

    echo $twig->render('agregar_peli.html', [
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol,
        'mensaje' => $mensaje
    ]);
?>