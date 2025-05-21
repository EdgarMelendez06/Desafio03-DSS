<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="card">            <h2><i class="fas fa-user-plus"></i> Registro de Usuario</h2>
            <?php
            session_start();
            if (isset($_SESSION['errores'])) {
                echo '<div class="alert alert-danger">';
                foreach ($_SESSION['errores'] as $error) {
                    echo htmlspecialchars($error) . '<br>';
                }
                echo '</div>';
                unset($_SESSION['errores']);
            }
            if (isset($_SESSION['mensaje'])) {
                echo '<div class="alert alert-success">';
                echo htmlspecialchars($_SESSION['mensaje']);
                echo '</div>';
                unset($_SESSION['mensaje']);
            }
            ?>
            <form method="post" action="../../controllers/AuthController.php?action=register">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" 
                           required pattern="[a-zA-Z0-9_-]{4,20}"
                           title="El usuario debe tener entre 4 y 20 caracteres y solo puede contener letras, números y guiones">
                </div>
                <div class="form-group">
                    <label for="nombre_completo">Nombre Completo</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" 
                           required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,100}"
                           title="El nombre completo solo puede contener letras y espacios">
                </div>                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" id="correo" name="correo" class="form-control" 
                           required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" class="form-control" 
                           required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
                           title="La contraseña debe tener al menos 6 caracteres, una letra y un número">
                </div>
                <div class="form-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn">
                        REGISTRARSE
                    </button>
                    <a href="login.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> CANCELAR
                    </a>
                </div>
            </form>
            <p style="margin-top: 1rem; text-align: center;">
                ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
            </p>
        </div>
    </div>
</body>
</html>
