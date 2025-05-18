<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/loginMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // Se comienza con una sesión ya iniciada
    $mensaje = "";
    $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : '';
    $nombreUsuario = isset($_GET['nombre']) ? $_GET['nombre'] : '';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $usuario = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $nombreActual = $_SESSION['usuarioAct'];
        $nuevoRol = isset($_POST['rol']) ? $_POST['rol'] : '';

        if($_SESSION['usuarioAct'] == "root") {
            $nombreActual = $nombreUsuario;
        }
        
        LoginModelo::actualizarDatos($usuario, $password, $email, 
                            $nuevoRol, $nombreActual);
        
        // Si el nombre de usuario es vacío es porque no lo ha modificado, entonces tiene el mismo
        // nombre de antes
        if($usuario == "") {
            $usuario = $nombreActual;
        }

        // Si el usuario de la sesión actual es root, entonces se mantiene el nombre de usuario como root
        // porque habrá ocurrido que el que ha modificado los datos del usuario ha sido root
        if($_SESSION['usuarioAct'] == "root") {
            $usuario = $_SESSION['usuarioAct'];
        }

        // Obtengo los datos del usuario (sin la contraseña)
        $datosUsuario = LoginModelo::getDatos($usuario);

        // Si los datos son correctos y se encuentran en la base de datos
        if ($datosUsuario && isset($datosUsuario['nombre'])) {
            // Actualizar la sesión
            $_SESSION['usuarioAct'] = $datosUsuario['nombre'];
            $_SESSION['rol'] = $datosUsuario['rol'];
            $_SESSION['email'] = $datosUsuario['email'];

            header("Location: portada.php");
            exit();
        } else {
            // Mostrar mensaje de error si la actualización falla
            $mensaje = "Error al actualizar los datos. Inténtalo de nuevo.";
        }
    }

    echo $twig->render('modificar_datos.html', [
        'mensaje' => $mensaje,
        'usuarioLog' => $_SESSION['usuarioAct'],
        'rolUsuario' => $_SESSION['rol'],
        'idUsuario' => $idUsuario,
        'nombre' => $nombreUsuario
    ]);
?>