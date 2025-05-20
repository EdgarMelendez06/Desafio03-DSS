<?php
class Usuario {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function registrar($usuario, $correo, $contrasena) {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (usuario, correo, contrasena) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$usuario, $correo, $hash]);
    }

    public function autenticar($usuario, $contrasena) {
        error_log("Intentando autenticar usuario: " . $usuario);
        
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            error_log("Usuario no encontrado: " . $usuario);
            return false;
        }

        error_log("Usuario encontrado, verificando contraseña");
        $passwordVerified = password_verify($contrasena, $user['contrasena']);
        error_log("Resultado de verificación de contraseña: " . ($passwordVerified ? 'correcta' : 'incorrecta'));

        if (!$passwordVerified) {
            error_log("Contraseña incorrecta para el usuario: " . $usuario);
            return false;
        }

        error_log("Autenticación exitosa para el usuario: " . $usuario);
        return $user;
    }
}
