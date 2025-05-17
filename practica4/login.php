<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/loginMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $mensaje = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $usuario = $_POST['username'];
        $password = $_POST['password'];
        $datosUsuario = LoginModelo::usuarioRegistrado($usuario, $password);

        if($datosUsuario == null) {
            $mensaje = "Usuario no registrado";
        }
        elseif($datosUsuario[0] < 0) {   // Usuario registrado pero contraseña incorrecta           
            $mensaje = "Contraseña incorrecta";
        }
        else {  // Usuario registrado correctamente
            session_start();    // inicio sesión para ese usuario
            $_SESSION['usuarioAct'] = $datosUsuario['nombre'];     // guardo el nombre del usuario actual
            $_SESSION['rol'] = $datosUsuario['rol'];    // guardo su rol
            $_SESSION['email'] = $datosUsuario['email'];
            header("Location: portada.php");    // Se redirige a la portada (página principal)
            exit();
        }
    }

    echo $twig->render('login.html', ['mensaje' => $mensaje]);
?>