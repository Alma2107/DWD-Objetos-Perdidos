<?php
require_once 'dao.php';
require_once '../php/Categoria.php';
require_once '../conexion.php';

class categoriaDAO implements DAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($categoria) {
        $sql = "INSERT INTO categoria (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $categoria->getNombre(), 
            $categoria->getDescripcion()
        ]);
    }

    public function modificar($categoria) {
        $sql = "UPDATE categoria SET nombre = ?, descripcion = ? WHERE id_categoria = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $categoria->getNombre(), 
            $categoria->getDescripcion(), 
            $categoria->getIdCategoria()
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM categoria WHERE id_categoria = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM categoria WHERE id_categoria = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new Categoria(
                $fila['id_categoria'], 
                $fila['nombre'], 
                $fila['descripcion']
            );
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM categoria";
        $stmt = $this->conexion->query($sql);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new Categoria(
                $fila['id_categoria'], 
                $fila['nombre'], 
                $fila['descripcion']
            );
        }
        return $resultados;
    }
}
?>