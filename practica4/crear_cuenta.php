<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/loginMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $mensaje = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $usuario = $_POST['username'];
        $password = $_POST['password'];
        $nickname = $_POST['nickname'];
        $datosUsuario = LoginModelo::usuarioRegistrado($usuario, $password);

        if($datosUsuario == null) {     // Usuario no registrado
            LoginModelo::registrarUsuario($usuario, $password, $nickname);
            $datosUsuario = LoginModelo::usuarioRegistrado($usuario, $password);
            
            session_start();    // inicio sesión para ese usuario
            $_SESSION['usuarioAct'] = $datosUsuario['nombre'];     // guardo el nombre del usuario actual
            $_SESSION['rol'] = $datosUsuario['rol'];    // guardo su rol
            header("Location: portada.php");    // Se redirige a la portada (página principal)
            exit();
        }
        else {
            $mensaje = "Usuario ya registrado en el sistema";
        }
    }


    echo $twig->render('crear_cuenta.html', ['mensaje' => $mensaje]);
?>