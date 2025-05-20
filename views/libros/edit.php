<h2>Editar Libro</h2>
<form method="post" action="../../controllers/LibroController.php?action=edit&id=<?= $libro['id'] ?>">
    Título: <input type="text" name="titulo" value="<?= htmlspecialchars($libro['titulo']) ?>" required><br>
    Autor: <input type="text" name="autor" value="<?= htmlspecialchars($libro['autor']) ?>" required><br>
    <button type="submit">Actualizar</button>
</form>
<p><a href="index.php">Volver</a></p>
