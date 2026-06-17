<?php
// Archivo: C:\xampp\htdocs\DWD-Objetos-Perdidos\Pagina_Web_Grupal\clases\daos\cateogoriaDao.php

require_once __DIR__ . '/dao.php';
require_once __DIR__ . '/../php/cateogoria.php';
require_once __DIR__ . '/../../conexion.php';

class categoriaDAO implements DAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($categoria): void {
        $sql = "INSERT INTO categoria (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            $categoria->getNombre(), 
            $categoria->getDescripcion()
        ]);
    }

    public function actualizar($categoria): void {
        $this->modificar($categoria);
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

    public function eliminar($id): void {
        $sql = "DELETE FROM categoria WHERE id_categoria = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
    }

    public function buscarPorId($id) {
        return $this->obtenerPorId($id);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM categoria WHERE id_categoria = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new categoria(
                $fila['id_categoria'], 
                $fila['nombre'], 
                $fila['descripcion']
            );
        }
        return null;
    }

    public function listar() {
        return $this->listarTodos();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM categoria";
        $stmt = $this->conexion->query($sql);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new categoria(
                $fila['id_categoria'], 
                $fila['nombre'], 
                $fila['descripcion']
            );
        }
        return $resultados;
    }
}
?>