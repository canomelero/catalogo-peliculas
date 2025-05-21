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

        if(!empty($img)) {
            PeliculaModelo::agregarImg($idPeli, $img);
            header("Location: pelicula.php?idPeli=$idPeli");
            exit();
        }
    }

    echo $twig->render('agregar_img.html', [
        'usuarioLog' => $usuarioLog,
        'rolUsuario' => $rol,
        'idPeli' => $idPeli
    ]);
?>