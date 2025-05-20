<?php
class Usuario {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }    public function validarUsuario($usuario, $nombre_completo, $correo, $contrasena) {
        $errores = [];
        
        // Validar usuario (solo letras, números y guiones)
        if (!preg_match('/^[a-zA-Z0-9_-]{4,20}$/', $usuario)) {
            $errores[] = "El usuario debe tener entre 4 y 20 caracteres y solo puede contener letras, números y guiones";
        }

        // Validar nombre completo (solo letras y espacios)
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,100}$/', $nombre_completo)) {
            $errores[] = "El nombre completo solo puede contener letras y espacios";
        }

        // Validar correo
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Correo electrónico no válido";
        }

        // Validar contraseña (mínimo 6 caracteres, al menos una letra y un número)
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $contrasena)) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres, una letra y un número";
        }

        return $errores;
    }

    public function registrar($usuario, $nombre_completo, $correo, $contrasena) {
        // Validar datos
        $errores = $this->validarUsuario($usuario, $nombre_completo, $correo, $contrasena);
        if (!empty($errores)) {
            return ['success' => false, 'errores' => $errores];
        }

        try {
            // Verificar si el usuario ya existe
            $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE usuario = ? OR correo = ?");
            $stmt->execute([$usuario, $correo]);
            if ($stmt->fetch()) {
                return ['success' => false, 'errores' => ['El usuario o correo ya existe']];
            }

            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (usuario, nombre_completo, correo, contrasena) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$usuario, $nombre_completo, $correo, $hash]);
            
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'errores' => ['Error en la base de datos: ' . $e->getMessage()]];
        }
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
