<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/loginMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $mensaje = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $usuario = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $datosUsuario = LoginModelo::usuarioRegistrado($usuario, $password);

        if($datosUsuario == null) {     // Usuario no registrado
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                LoginModelo::registrarUsuario($usuario, $password, $email);
                $datosUsuario = LoginModelo::usuarioRegistrado($usuario, $password);
                
                session_start();    // inicio sesión para ese usuario
                $_SESSION['usuarioAct'] = $datosUsuario['nombre'];     // guardo el nombre del usuario actual
                $_SESSION['rol'] = $datosUsuario['rol'];    // guardo su rol
                $_SESSION['email'] = $datosUsuario['email'];
                header("Location: portada.php");    // Se redirige a la portada (página principal)
                exit();
            }
            else {
                $mensaje = "Email no correcto";
            }
        }
        else {
            $mensaje = "Usuario ya registrado en el sistema";
        }
    }


    echo $twig->render('crear_cuenta.html', ['mensaje' => $mensaje]);
?>