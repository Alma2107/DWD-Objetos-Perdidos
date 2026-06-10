<?php
require_once 'dao.php';
require_once '../php/Solicitud.php';
require_once '../../conexion.php';

class solicitudDAO implements DAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($solicitud) {
        $sql = "INSERT INTO solicitud (id_solicitante, id_objeto, id_estado_solicitud, id_administrador, fecha_solicitud, descripcion_propiedad, fecha_resolucion, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $solicitud->getIdSolicitante(), 
            $solicitud->getIdObjeto(), 
            $solicitud->getIdEstadoSolicitud(), 
            $solicitud->getIdAdministrador(), 
            $solicitud->getFechaSolicitud(), 
            $solicitud->getDescripcionPropiedad(), 
            $solicitud->getFechaResolucion(), 
            $solicitud->getObservaciones()
        ]);
    }

    public function modificar($solicitud) {
        $sql = "UPDATE solicitud SET id_solicitante = ?, id_objeto = ?, id_estado_solicitud = ?, id_administrador = ?, fecha_solicitud = ?, descripcion_propiedad = ?, fecha_resolucion = ?, observaciones = ? WHERE id_solicitud = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $solicitud->getIdSolicitante(), 
            $solicitud->getIdObjeto(), 
            $solicitud->getIdEstadoSolicitud(), 
            $solicitud->getIdAdministrador(), 
            $solicitud->getFechaSolicitud(), 
            $solicitud->getDescripcionPropiedad(), 
            $solicitud->getFechaResolucion(), 
            $solicitud->getObservaciones(), 
            $solicitud->getIdSolicitud()
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM solicitud WHERE id_solicitud = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM solicitud WHERE id_solicitud = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new Solicitud(
                $fila['id_solicitud'], 
                $fila['id_solicitante'], 
                $fila['id_objeto'], 
                $fila['id_estado_solicitud'], 
                $fila['id_administrador'], 
                $fila['fecha_solicitud'], 
                $fila['descripcion_propiedad'], 
                $fila['fecha_resolucion'], 
                $fila['observaciones']
            );
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM solicitud";
        $stmt = $this->conexion->query($sql);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new Solicitud(
                $fila['id_solicitud'], 
                $fila['id_solicitante'], 
                $fila['id_objeto'], 
                $fila['id_estado_solicitud'], 
                $fila['id_administrador'], 
                $fila['fecha_solicitud'], 
                $fila['descripcion_propiedad'], 
                $fila['fecha_resolucion'], 
                $fila['observaciones']
            );
        }
        return $resultados;
    }
}
?>