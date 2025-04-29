<?php
    require_once __DIR__ . "/../baseDatos.php";

    class LoginModelo {
        public static function usuarioRegistrado($usuario, $password): ?array {
            $conn = BaseDatos::getConexion();
            $stmt = $conn->prepare("SELECT usuarios.nombre, usuarios.password, roles.nombre AS rol 
                                FROM usuarios 
                                JOIN roles ON usuarios.rol_id = roles.id 
                                WHERE usuarios.nombre = ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            $datosUsuario = null;
            
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Si la contraseña coincide, es que el usuario está en el sistema registrado
                if(password_verify($password, $row["password"])) {  
                    $datosUsuario = array(
                        "nombre"=> $row["nombre"],
                        "rol" => $row["rol"],
                    );
                }
                else {  // Si la contraseña no coincide, se envía un int negativo a modo de error
                    $datosUsuario = array(-1);
                }
            }

            return $datosUsuario;
        }

        public static function registrarUsuario($usuario, $password) {
            $conn = BaseDatos::getConexion();

            if($usuario == "root" || $usuario == "admin") {
                $rol = "admin";
            }
            elseif($usuario == "moderador") {
                $rol = "moderador";
            }
            elseif($usuario == "gestor") {
                $rol = "gestor";
            }
            else {
                $rol = "registrado";
            }

            $idRol = self::getRol($rol);
            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, password, rol_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $usuario, $password, $idRol);
            $stmt->execute();
        }

        public static function getRol($rol): ?int {
            $conn = BaseDatos::getConexion();

            $stmt = $conn->prepare("SELECT id FROM roles WHERE nombre = ?");
            $stmt->bind_param("s", $rol);
            $stmt->execute();
            $result = $stmt->get_result();
            $idRol = null;

            if($row = $result->fetch_assoc()) {
                $idRol = $row['id'];
            }

            return $idRol;
        }
    }
?>