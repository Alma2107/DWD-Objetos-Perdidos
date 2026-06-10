<?php
require_once 'dao.php';
require_once '../php/EstadoObjeto.php';
require_once '../conexion.php';

class estadoObjetoDAO implements DAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($estado) {
        $sql = "INSERT INTO estado_objeto (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $estado->getNombre(), 
            $estado->getDescripcion()
        ]);
    }

    public function modificar($estado) {
        $sql = "UPDATE estado_objeto SET nombre = ?, descripcion = ? WHERE id_estado_objeto = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $estado->getNombre(), 
            $estado->getDescripcion(), 
            $estado->getIdEstadoObjeto()
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM estado_objeto WHERE id_estado_objeto = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM estado_objeto WHERE id_estado_objeto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new EstadoObjeto(
                $fila['id_estado_objeto'], 
                $fila['nombre'], 
                $fila['descripcion']
            );
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM estado_objeto";
        $stmt = $this->conexion->query($sql);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new EstadoObjeto(
                $fila['id_estado_objeto'], 
                $fila['nombre'], 
                $fila['descripcion']
            );
        }
        return $resultados;
    }
}
?>