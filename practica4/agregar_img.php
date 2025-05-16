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
        if(isset($_FILES['imagen'])){
            $errors= array();
            $file_name = $_FILES['imagen']['name'];
            $file_size = $_FILES['imagen']['size'];
            $file_tmp = $_FILES['imagen']['tmp_name'];
            $file_type = $_FILES['imagen']['type'];
            $file_ext = strtolower(end(explode('.',$_FILES['imagen']['name'])));
            
            $extensions= array("jpeg","jpg","png");
            
            if (in_array($file_ext,$extensions) === false){
              $errors[] = "Extensión no permitida, elige una imagen JPEG o PNG.";
            }
            
            if ($file_size > 2097152){
              $errors[] = 'Tamaño del fichero demasiado grande';
            }
            
            if(empty($errors)==true) {
              move_uploaded_file($file_tmp, "img/" . $file_name);
              
              $varsParaTwig['imagen'] = "img/" . $file_name;

              $img = "./img/" . $file_name;
            }
            
            if (sizeof($errors) > 0) {
              $varsParaTwig['errores'] = $errors;
            }
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