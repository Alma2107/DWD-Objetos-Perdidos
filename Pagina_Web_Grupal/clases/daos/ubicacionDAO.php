<?php
require_once 'dao.php';
require_once __DIR__ . '/../php/Ubicacion.php';
require_once '../conexion.php';

class UbicacionDAO implements DAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($ubicacion) {
        $sql = "INSERT INTO ubicacion (nombre, sector, descripcion) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $ubicacion->getNombre(), 
            $ubicacion->getSector(), 
            $ubicacion->getDescripcion()
        ]);
    }

    public function modificar($ubicacion) {
        $sql = "UPDATE ubicacion SET nombre = ?, sector = ?, descripcion = ? WHERE id_ubicacion = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $ubicacion->getNombre(), 
            $ubicacion->getSector(), 
            $ubicacion->getDescripcion(), 
            $ubicacion->getIdUbicacion()
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM ubicacion WHERE id_ubicacion = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM ubicacion WHERE id_ubicacion = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new Ubicacion(
                $fila['id_ubicacion'], 
                $fila['nombre'], 
                $fila['sector'], 
                $fila['descripcion']
            );
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM ubicacion";
        $stmt = $this->conexion->query($sql);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new Ubicacion(
                $fila['id_ubicacion'], 
                $fila['nombre'], 
                $fila['sector'], 
                $fila['descripcion']
            );
        }
        return $resultados;
    }
}
?>