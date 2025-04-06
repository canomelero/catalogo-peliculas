<?php
    $conex = mysqli_connect("localhost", "root", "", "sibw", "3306");

    if($conex) {
        echo "Conexión correcta";
    }
    else {
        echo "Conexión fallida";
    }
?>