<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['errores'] = ['ID no proporcionado'];
    header("Location: index.php");
    exit;
}

require_once '../../config/database.php';
require_once '../../models/Libro.php';

$libroModel = new Libro($conn);
$libro = $libroModel->obtenerPorId($_GET['id']);

if (!$libro) {
    $_SESSION['errores'] = ['Libro no encontrado'];
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Libro</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="card">            
            <h2><i class="fas fa-trash-alt"></i> Eliminar Libro</h2>
            <div class="alert alert-danger" style="margin-bottom: 2rem;">
                <p><i class="fas fa-exclamation-triangle"></i> ¿Estás seguro que deseas eliminar el libro:</p>
                <p style="margin-top: 1rem;">
                    <strong><?= htmlspecialchars($libro['titulo']) ?></strong><br>
                    <em>por <?= htmlspecialchars($libro['autor']) ?></em>
                </p>
            </div>            <div class="form-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
                <form method="post" action="../../controllers/LibroController.php?action=delete&id=<?= $libro['id'] ?>">
                    <button type="submit" class="btn">
                        GUARDAR CAMBIOS
                    </button>
                </form>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> CANCELAR
                </a>
            </div>
        </div>
    </div>
</body>
</html>
