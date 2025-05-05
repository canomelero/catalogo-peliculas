<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/modelos/loginMod.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();    // Se comienza con una sesión ya iniciada
    $mensaje = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $usuario = $_POST['username'];
        $password = $_POST['password'];
        $nickname = $_POST['nickname'];
        
        LoginModelo::actualizarDatos($usuario, $password, $nickname, 
                            $_SESSION['usuarioAct']);
        $datosUsuario = LoginModelo::usuarioRegistrado($usuario, $password);

        // Después de actualizar los datos, se destruye la sesión que había, se crea una nueva
        // con los datos nuevos y se redirige a la portada
        session_destroy();  
        session_start();    
        $_SESSION['usuarioAct'] = $datosUsuario['nombre'];    
        $_SESSION['rol'] = $datosUsuario['rol'];   
        header("Location: portada.php");    
        exit();
    }

    echo $twig->render('modificar_datos.html', ['mensaje' => $mensaje]);
?>