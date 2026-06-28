<?php
require_once __DIR__ . '/dao.php';
require_once __DIR__ . '/../php/EstadoSolicitud.php';
require_once __DIR__ . '/../../conexion.php';

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

    public function obtenerEstadoInicial() {
        $sql = "SELECT * FROM estado_solicitud
                WHERE LOWER(nombre) IN ('pendiente', 'en revision')
                   OR LOWER(nombre) LIKE 'en revisi%'
                ORDER BY id_estado_solicitud ASC
                LIMIT 1";
        $stmt = $this->conexion->query($sql);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            $estados = $this->listarTodos();
            if (!empty($estados)) {
                return $estados[0];
            }

            $this->insertar(new EstadoSolicitud(
                null,
                'Pendiente',
                'Solicitud recibida y pendiente de revision.'
            ));
            return $this->obtenerPorId((int)$this->conexion->lastInsertId());
        }

        return new EstadoSolicitud(
            $fila['id_estado_solicitud'],
            $fila['nombre'],
            $fila['descripcion']
        );
    }
}
?>
