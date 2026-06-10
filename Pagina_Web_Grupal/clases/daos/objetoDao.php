<?php
require_once 'dao.php';
require_once '../php/Objeto.php';
require_once '../../conexion.php';

class objetoDAO implements DAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($objeto) {
        $sql = "INSERT INTO objeto (id_categoria, id_ubicacion, id_estado_objeto, id_administrador, nombre, descripcion, color, marca, fecha_encontrado, fecha_registro, foto, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $objeto->getIdCategoria(), 
            $objeto->getIdUbicacion(), 
            $objeto->getIdEstadoObjeto(), 
            $objeto->getIdAdministrador(), 
            $objeto->getNombre(), 
            $objeto->getDescripcion(), 
            $objeto->getColor(), 
            $objeto->getMarca(), 
            $objeto->getFechaEncontrado(), 
            $objeto->getFechaRegistro(), 
            $objeto->getFoto(), 
            $objeto->getObservaciones()
        ]);
    }

    public function modificar($objeto) {
        $sql = "UPDATE objeto SET id_categoria = ?, id_ubicacion = ?, id_estado_objeto = ?, id_administrador = ?, nombre = ?, descripcion = ?, color = ?, marca = ?, fecha_encontrado = ?, foto = ?, observaciones = ? WHERE id_objeto = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $objeto->getIdCategoria(), 
            $objeto->getIdUbicacion(), 
            $objeto->getIdEstadoObjeto(), 
            $objeto->getIdAdministrador(), 
            $objeto->getNombre(), 
            $objeto->getDescripcion(), 
            $objeto->getColor(), 
            $objeto->getMarca(), 
            $objeto->getFechaEncontrado(), 
            $objeto->getFoto(), 
            $objeto->getObservaciones(), 
            $objeto->getIdObjeto()
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM objeto WHERE id_objeto = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM objeto WHERE id_objeto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new Objeto(
                $fila['id_objeto'], 
                $fila['id_categoria'], 
                $fila['id_ubicacion'], 
                $fila['id_estado_objeto'], 
                $fila['id_administrador'], 
                $fila['nombre'], 
                $fila['descripcion'], 
                $fila['color'], 
                $fila['marca'], 
                $fila['fecha_encontrado'], 
                $fila['fecha_registro'], 
                $fila['foto'], 
                $fila['observaciones']
            );
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM objeto";
        $stmt = $this->conexion->query($sql);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new Objeto(
                $fila['id_objeto'], 
                $fila['id_categoria'], 
                $fila['id_ubicacion'], 
                $fila['id_estado_objeto'], 
                $fila['id_administrador'], 
                $fila['nombre'], 
                $fila['descripcion'], 
                $fila['color'], 
                $fila['marca'], 
                $fila['fecha_encontrado'], 
                $fila['fecha_registro'], 
                $fila['foto'], 
                $fila['observaciones']
            );
        }
        return $resultados;
    }

    public function listarPorCategoria($id_categoria) {
        $sql = "SELECT * FROM objeto WHERE id_categoria = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id_categoria]);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new Objeto(
                $fila['id_objeto'], 
                $fila['id_categoria'], 
                $fila['id_ubicacion'], 
                $fila['id_estado_objeto'], 
                $fila['id_administrador'], 
                $fila['nombre'], 
                $fila['descripcion'], 
                $fila['color'], 
                $fila['marca'], 
                $fila['fecha_encontrado'], 
                $fila['fecha_registro'], 
                $fila['foto'], 
                $fila['observaciones']
            );
        }
        return $resultados;
    }
}
?>