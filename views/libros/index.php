<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: ../auth/login.php");
        exit;
    }

    require_once '../../config/database.php';
    require_once '../../models/Libro.php';

    $libroModel = new Libro($conn);
    $libros = $libroModel->obtenerTodos();
    ?>    <div class="container">
        <div class="navbar">
            <h2><i class="fas fa-book"></i> Lista de Libros</h2>
            <div>
                <a href="../../controllers/LibroController.php?action=create" class="btn">
                    <i class="fas fa-plus"></i> Agregar nuevo libro
                </a>
                <a href="../welcome.php" class="btn">
                    <i class="fas fa-home"></i> Volver al inicio
                </a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $libro): ?>
                    <tr>
                        <td><?= $libro['id'] ?></td>
                        <td><?= htmlspecialchars($libro['titulo']) ?></td>
                        <td><?= htmlspecialchars($libro['autor']) ?></td>
                        <td class="actions">                            <a href="../../controllers/LibroController.php?action=edit&id=<?= $libro['id'] ?>" class="btn">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="../../controllers/LibroController.php?action=delete&id=<?= $libro['id'] ?>" 
                               onclick="return confirm('¿Está seguro de que desea eliminar este libro?')" 
                               class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
