<?php
session_start();
require_once '../config/database.php';
require_once '../models/Usuario.php';

$usuarioModel = new Usuario($conn);
$action = $_GET['action'] ?? '';

if ($action == 'register') {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    if ($usuarioModel->registrar($usuario, $correo, $contrasena)) {
        header("Location: ../views/auth/login.php");
    } else {
        echo "Error al registrar";
    }
} elseif ($action == 'login') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    error_log("Intento de login - Usuario: " . $usuario);

    $user = $usuarioModel->autenticar($usuario, $contrasena);

    if ($user) {
        error_log("Login exitoso para el usuario: " . $usuario);
        $_SESSION['usuario'] = $user['usuario'];
        header("Location: ../views/welcome.php");
    } else {
        error_log("Login fallido para el usuario: " . $usuario);
        echo "Usuario o contraseña incorrectos.";
    }
}
