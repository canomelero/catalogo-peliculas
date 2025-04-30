<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/loginMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $usuario = $_POST['username'];
        $password = $_POST['password'];
        $nickname = $_POST['nickname'];
        $datosUsuario = LoginModelo::usuarioRegistrado($usuario, $password);
        $mensaje = "";

        if($datosUsuario == null) {     // Usuario no registrado
            LoginModelo::registrarUsuario($usuario, $password, $nickname);
            header("Location: portada.php");
            exit();
        }
        else {
            $mensaje = "Usuario ya registrado en el sistema";
        }
    }


    echo $twig->render('crear_cuenta.html', ['mensaje' => $mensaje]);
?>