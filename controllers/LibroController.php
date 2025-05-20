<?php
require_once '../config/database.php';
require_once '../models/Libro.php';

$libroModel = new Libro($conn);
$action = $_GET['action'] ?? 'index';

switch ($action) {    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $autor = trim($_POST['autor'] ?? '');
            
            $resultado = $libroModel->crear($titulo, $autor);
            
            if ($resultado['success']) {
                $_SESSION['mensaje'] = "Libro creado exitosamente";
            } else {
                $_SESSION['errores'] = $resultado['errores'];
            }
            header("Location: ../views/libros/index.php");
            exit;
        }
        header("Location: ../views/libros/index.php");
        break;    case 'edit':
        if (!isset($_GET['id'])) {
            $_SESSION['errores'] = ['ID no proporcionado'];
            header("Location: ../views/libros/index.php");
            exit;
        }
        
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $autor = trim($_POST['autor'] ?? '');
            
            $resultado = $libroModel->validarLibro($titulo, $autor);
            if (empty($resultado)) {
                if ($libroModel->actualizar($id, $titulo, $autor)) {
                    $_SESSION['mensaje'] = "Libro actualizado exitosamente";
                    header("Location: ../views/libros/index.php");
                } else {
                    $_SESSION['errores'] = ['Error al actualizar el libro'];
                    header("Location: ../views/libros/edit.php?id=" . $id);
                }
            } else {
                $_SESSION['errores'] = $resultado;
                header("Location: ../views/libros/edit.php?id=" . $id);
            }
            exit;
        }
        header("Location: ../views/libros/edit.php?id=" . $id);
        exit;
        break;case 'delete':
        if (!isset($_GET['id'])) {
            $_SESSION['errores'] = ['ID no proporcionado'];
            header("Location: ../views/libros/index.php");
            exit;
        }

        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($libroModel->eliminar($id)) {
                $_SESSION['mensaje'] = "Libro eliminado exitosamente";
            } else {
                $_SESSION['errores'] = ["Error al eliminar el libro"];
            }
            header("Location: ../views/libros/index.php");
            exit;
        }
        header("Location: ../views/libros/index.php");
        break;


    default:
        $libros = $libroModel->obtenerTodos();
        include '../views/libros/index.php';
        break;
}
