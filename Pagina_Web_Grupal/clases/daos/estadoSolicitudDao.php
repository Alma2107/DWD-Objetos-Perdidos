<?php
require_once 'dao.php';
require_once '../php/EstadoSolicitud.php';
require_once '../conexion.php';

class EstadoSolicitudDAO implements DAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($estado) {
        $sql = "INSERT INTO estado_solicitud (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $estado->getNombre(), 
            $estado->getDescripcion()
        ]);
    }

    public function modificar($estado) {
        $sql = "UPDATE estado_solicitud SET nombre = ?, descripcion = ? WHERE id_estado_solicitud = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $estado->getNombre(), 
            $estado->getDescripcion(), 
            $estado->getIdEstadoSolicitud()
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM estado_solicitud WHERE id_estado_solicitud = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM estado_solicitud WHERE id_estado_solicitud = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new EstadoSolicitud(
                $fila['id_estado_solicitud'], 
                $fila['nombre'], 
                $fila['descripcion']
            );
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM estado_solicitud";
        $stmt = $this->conexion->query($sql);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new EstadoSolicitud(
                $fila['id_estado_solicitud'], 
                $fila['nombre'], 
                $fila['descripcion']
            );
        }
        return $resultados;
    }
}
?>