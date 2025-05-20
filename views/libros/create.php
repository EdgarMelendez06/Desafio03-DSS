<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Libro</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Agregar Libro</h2>            <?php
            session_start();
            if (isset($_SESSION['errores'])) {
                echo '<div class="alert alert-danger">';
                foreach ($_SESSION['errores'] as $error) {
                    echo htmlspecialchars($error) . '<br>';
                }
                echo '</div>';
                unset($_SESSION['errores']);
            }
            ?>
            <form method="post" action="../../controllers/LibroController.php?action=create">
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" 
                           required maxlength="100"
                           pattern=".{1,100}"
                           title="El título no puede estar vacío y debe tener máximo 100 caracteres">
                </div>                <div class="form-group">
                    <label for="autor">Autor</label>
                    <input type="text" id="autor" name="autor" class="form-control" 
                           required maxlength="100"
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.]+"
                           title="El autor solo puede contener letras, espacios y puntos">
                </div>
                <div class="form-group" style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="index.php" class="btn btn-danger">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
