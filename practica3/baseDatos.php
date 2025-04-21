<?php
    // Archivo de la base de datos que permite crear una conexión a la base de datos
    class BaseDatos {
        private static string $hostname = "localhost";
        private static string $username = "jorge";
        private static string $password = "1234";
        private static string $database = "sibw";
        private static string $port = "3306";
        private static ?mysqli $conex = null;   // objeto mysqli que puede ser null

        // Método estático para no tener que hacer una instancia de la clase
        public static function getConexion(): mysqli {
            if(self::$conex == null) {
                self::$conex = new mysqli(self::$hostname, self::$username, self::$password
                                , self::$database, self::$port);
                
                if(self::$conex->connect_error) {
                    die("Conexión fallida: " . self::$conex->connect_error);  
                }
            }

            return self::$conex;
        }

        // Método estático para cerrar la conexión de la base de datos
        public static function cerrarConexion(): void {
            if(self::$conex != null) {
                self::$conex->close();
                self::$conex = null;
            }
        }
    }
?>