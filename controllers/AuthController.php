<?php
session_start();
require_once '../config/database.php';
require_once '../models/Usuario.php';

$usuarioModel = new Usuario($conn);
$action = $_GET['action'] ?? '';

if ($action == 'register') {
    $usuario = trim($_POST['usuario'] ?? '');
    $nombre_completo = trim($_POST['nombre_completo'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (empty($usuario) || empty($nombre_completo) || empty($correo) || empty($contrasena)) {
        $_SESSION['errores'] = ['Todos los campos son obligatorios'];
        header("Location: ../views/auth/register.php");
        exit;
    }

    $resultado = $usuarioModel->registrar($usuario, $nombre_completo, $correo, $contrasena);
    
    if ($resultado['success']) {
        $_SESSION['mensaje'] = "Usuario registrado exitosamente";
        header("Location: ../views/auth/login.php");
    } else {
        $_SESSION['errores'] = $resultado['errores'];
        header("Location: ../views/auth/register.php");
    }
    exit;
}elseif ($action == 'login') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    error_log("Intento de login - Usuario: " . $usuario);    $user = $usuarioModel->autenticar($usuario, $contrasena);

    if ($user) {
        error_log("Login exitoso para el usuario: " . $usuario);
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre_completo'] = $user['nombre_completo'];
        header("Location: ../views/welcome.php");
    } else {
        error_log("Login fallido para el usuario: " . $usuario);
        echo "Usuario o contraseña incorrectos.";
    }
}
