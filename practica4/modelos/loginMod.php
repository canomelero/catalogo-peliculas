<?php
    require_once __DIR__ . "/../baseDatos.php";

    class LoginModelo {
        public static function usuarioRegistrado($usuario, $password): ?array {
            $conn = BaseDatos::getConexion();
            $stmt = $conn->prepare("SELECT usuarios.nombre, usuarios.password, usuarios.email, roles.nombre AS rol 
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
                        "email" => $row["email"]
                    );
                }
                else {  // Si la contraseña no coincide, se envía un int negativo a modo de error
                    $datosUsuario = array(-1);
                }
            }

            return $datosUsuario;
        }

        public static function getDatos($usuario) {
            $conn = BaseDatos::getConexion();
            $stmt = $conn->prepare("SELECT usuarios.nombre, usuarios.email, roles.nombre AS rol 
                                FROM usuarios 
                                JOIN roles ON usuarios.rol_id = roles.id 
                                WHERE usuarios.nombre = ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            $datosUsuario = null;
            
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $datosUsuario = array(
                    "nombre"=> $row["nombre"],
                    "rol" => $row["rol"],
                    "email" => $row["email"]
                );
            }

            return $datosUsuario;
        }

        public static function registrarUsuario($usuario, $password, $email) {
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

            try {
                $stmt = $conn->prepare("INSERT INTO usuarios (nombre, password, email, rol_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $usuario, $password, $email, $idRol);
                $stmt->execute();
            } catch (Throwable $e) {
                die("Error en registrarUsuario: " . $e->getMessage());
            }
        }

        public static function getRol($rol): ?int {
            $conn = BaseDatos::getConexion();

            $stmt = $conn->prepare("SELECT id FROM roles WHERE nombre = ?");
            $stmt->bind_param("s", $rol);
            $stmt->execute();
            $result = $stmt->get_result();
            $idRol = null;

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $idRol = $row['id'];
            }

            return $idRol;
        }

        public static function actualizarDatos($usuario, $password, $email, $rol, $nombreInicial) {
            $conn = BaseDatos::getConexion();

            if($password != "" || $password != null) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE nombre = ?");
                $stmt->bind_param("ss", $password, $nombreInicial);
                $stmt->execute();
            }

            if(($email != "" || $email != null) && filter_var($email, FILTER_VALIDATE_EMAIL)) {    
                $stmt = $conn->prepare("UPDATE usuarios SET email = ? WHERE nombre = ?");
                $stmt->bind_param("ss", $email, $nombreInicial);
                $stmt->execute();
            }

            if($rol != "" || $rol != null) {
                // Se obtiene el rol del usuario
                $idRol = self::getRol($rol);

                // Se actualiza el rol al nuevo
                $stmt = $conn->prepare("UPDATE usuarios SET rol_id = ? WHERE nombre = ?");
                $stmt->bind_param("is", $idRol, $nombreInicial);
                $stmt->execute();
            }

            if($usuario != "" || $usuario != null) {   
                // Se actualiza la tabla de comentarios
                $stmt = $conn->prepare("UPDATE comentarios SET autor = ? WHERE autor = ?");
                $stmt->bind_param("ss", $usuario, $nombreInicial);
                $stmt->execute();
                
                // Se actualiza la tabla de usuarios
                $stmt = $conn->prepare("UPDATE usuarios SET nombre = ? WHERE nombre = ?");
                $stmt->bind_param("ss", $usuario, $nombreInicial);
                $stmt->execute();
            }
        }

        public static function getAllUsuarios() {
            $conn = BaseDatos::getConexion();


            $result = $conn->query("SELECT u.id, u.nombre, u.email, rol.nombre AS nombre_rol 
                                    FROM usuarios u
                                    LEFT JOIN roles rol ON u.rol_id = rol.id");
            
            $usuarios = [];

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $usuarios[] = array(
                        "id" => $row["id"],
                        "nombre" => $row["nombre"],
                        "email" => $row["email"],
                        "rol" => $row["nombre_rol"]
                    );
                }
            }

            return $usuarios;
        }
    }
?>