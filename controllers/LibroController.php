<?php
require_once '../config/database.php';
require_once '../models/Libro.php';

$libroModel = new Libro($conn);
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libroModel->crear($_POST['titulo'], $_POST['autor']);
            header("Location: ../views/libros/index.php");
        } else {
            include '../views/libros/create.php';
        }
        break;

    case 'edit':
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libroModel->actualizar($id, $_POST['titulo'], $_POST['autor']);
            header("Location: ../views/libros/index.php");
        } else {
            $libro = $libroModel->obtenerPorId($id);
            include '../views/libros/edit.php';
        }
        break;

    case 'delete':
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libroModel->eliminar($id);
            header("Location: ../views/libros/index.php");
        } else {
            $libro = $libroModel->obtenerPorId($id);
            include '../views/libros/delete.php';
        }
        break;


    default:
        $libros = $libroModel->obtenerTodos();
        include '../views/libros/index.php';
        break;
}
