<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container welcome-container">
        <h2><i class="fas fa-user-circle"></i> Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
        <div class="menu-links">
            <a href="libros/index.php" class="btn">
                <i class="fas fa-book"></i> Gestionar Libros
            </a>
            <a href="../logout.php" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </a>
        </div>
    </div>
</body>
</html>
