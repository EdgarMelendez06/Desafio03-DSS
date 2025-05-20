<?php
class Libro {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function obtenerTodos() {
        $stmt = $this->conn->query("SELECT * FROM libros");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM libros WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($titulo, $autor) {
        $stmt = $this->conn->prepare("INSERT INTO libros (titulo, autor) VALUES (?, ?)");
        return $stmt->execute([$titulo, $autor]);
    }

    public function actualizar($id, $titulo, $autor) {
        $stmt = $this->conn->prepare("UPDATE libros SET titulo = ?, autor = ? WHERE id = ?");
        return $stmt->execute([$titulo, $autor, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM libros WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
