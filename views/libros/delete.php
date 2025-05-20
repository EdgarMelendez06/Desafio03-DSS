<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Validamos que exista el ID
if (!isset($_GET['id'])) {
    echo "ID no proporcionado.";
    exit;
}

require_once '../../config/database.php';
require_once '../../models/Libro.php';

$libroModel = new Libro($conn);
$libro = $libroModel->obtenerPorId($_GET['id']);

if (!$libro) {
    echo "Libro no encontrado.";
    exit;
}
?>

<h2>Eliminar Libro</h2>
<p>¿Estás seguro que deseas eliminar el libro: <strong><?= htmlspecialchars($libro['titulo']) ?></strong> de <?= htmlspecialchars($libro['autor']) ?>?</p>

<form method="post" action="../../controllers/LibroController.php?action=delete&id=<?= $libro['id'] ?>">
    <button type="submit">Sí, eliminar</button>
    <a href="index.php">Cancelar</a>
</form>
