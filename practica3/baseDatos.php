<?php
    // Archivo de la base de datos que permite crear una conexión a la base de datos
    class BaseDatos {
        private static string $hostname = "localhost";
        private static string $username = "root";
        private static string $password = "";
        private static string $database = "sibw";
        private static string $port = "3306";

        // Método estático para no tener que hacer una instancia de la clase
        public static function getConexion(): mysqli {
            $conex = new mysqli(self::$hostname, self::$username, self::$password
                                , self::$database, self::$port);
            
            if($conex->connect_error) {
                die("Conexión fallida: " . $conex->connect_error);  
            }

            return $conex;
        }
    }
?>