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
    <title>Editar Libro</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h2><i class="fas fa-edit"></i> Editar Libro</h2>
            <?php
if (isset($_SESSION['errores'])) {
    echo '<div class="alert alert-danger">';
    foreach ($_SESSION['errores'] as $error) {
        echo htmlspecialchars($error) . '<br>';
    }
    echo '</div>';
    unset($_SESSION['errores']);
}
?>            <form method="post" action="../../controllers/LibroController.php?action=edit&id=<?= $libro['id'] ?>">
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" 
                           value="<?= htmlspecialchars($libro['titulo']) ?>"
                           required maxlength="100"
                           pattern=".{1,100}"
                           title="El título no puede estar vacío y debe tener máximo 100 caracteres">
                </div>
                <div class="form-group">
                    <label for="autor">Autor</label>
                    <input type="text" id="autor" name="autor" class="form-control" 
                           value="<?= htmlspecialchars($libro['autor']) ?>"
                           required maxlength="100"
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.]+"
                           title="El autor solo puede contener letras, espacios y puntos">
                </div>
                <div class="form-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn">
                        GUARDAR CAMBIOS
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> CANCELAR
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
