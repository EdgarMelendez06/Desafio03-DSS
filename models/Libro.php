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
    }    public function validarLibro($titulo, $autor) {
        $errores = [];
        
        // Validar título
        if (empty(trim($titulo))) {
            $errores[] = "El título no puede estar vacío";
        } elseif (strlen($titulo) > 100) {
            $errores[] = "El título no puede tener más de 100 caracteres";
        }
        
        // Validar autor
        if (empty(trim($autor))) {
            $errores[] = "El autor no puede estar vacío";
        } elseif (strlen($autor) > 100) {
            $errores[] = "El autor no puede tener más de 100 caracteres";
        } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.]+$/', $autor)) {
            $errores[] = "El autor solo puede contener letras, espacios y puntos";
        }
        
        return $errores;
    }

    public function crear($titulo, $autor) {
        $errores = $this->validarLibro($titulo, $autor);
        if (!empty($errores)) {
            return ['success' => false, 'errores' => $errores];
        }

        try {
            $stmt = $this->conn->prepare("INSERT INTO libros (titulo, autor) VALUES (?, ?)");
            $stmt->execute([trim($titulo), trim($autor)]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'errores' => ['Error en la base de datos: ' . $e->getMessage()]];
        }
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
