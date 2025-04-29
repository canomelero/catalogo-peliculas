<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/loginMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $usuario = $_POST['username'];
        $password = $_POST['password'];
        $datosUsuario = LoginModelo::usuarioRegistrado($usuario, $password);

        if($datosUsuario == null) {   // Si el usuario no está registrado, se crea            
            LoginModelo::registrarUsuario($usuario, $password);
            $datosUsuario = LoginModelo::usuarioRegistrado($usuario, $password);
        }
        elseif($datosUsuario[0] < 0) {  // La contraseña no coincide; se redirige a la misma página de login
            header("Location: login.php");
            exit();
        }
        
        session_start();    // inicio sesión para ese usuario
        $_SESSION['usuarioAct'] = $datosUsuario['nombre'];     // guardo el nombre del usuario actual
        $_SESSION['rol'] = $datosUsuario['rol'];    // guardo su rol
        header("Location: portada.php");    // Se redirige a la portada (página principal)
        exit();
    }


    echo $twig->render('login.html', []);
?>