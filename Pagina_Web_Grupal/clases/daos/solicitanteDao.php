<?php
require_once 'dao.php';
require_once '../php/Solicitante.php';
require_once '../conexion.php';

class solicitanteDAO implements DAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($solicitante) {
        $sql = "INSERT INTO solicitante (nombre, apellido, curso, division, email, telefono) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $solicitante->getNombre(), 
            $solicitante->getApellido(), 
            $solicitante->getCurso(), 
            $solicitante->getDivision(), 
            $solicitante->getEmail(), 
            $solicitante->getTelefono()
        ]);
    }

    public function modificar($solicitante) {
        $sql = "UPDATE solicitante SET nombre = ?, apellido = ?, curso = ?, division = ?, email = ?, telefono = ? WHERE id_solicitante = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $solicitante->getNombre(), 
            $solicitante->getApellido(), 
            $solicitante->getCurso(), 
            $solicitante->getDivision(), 
            $solicitante->getEmail(), 
            $solicitante->getTelefono(), 
            $solicitante->getIdSolicitante()
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM solicitante WHERE id_solicitante = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM solicitante WHERE id_solicitante = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new Solicitante(
                $fila['id_solicitante'], 
                $fila['nombre'], 
                $fila['apellido'], 
                $fila['curso'], 
                $fila['division'], 
                $fila['email'], 
                $fila['telefono']
            );
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM solicitante";
        $stmt = $this->conexion->query($sql);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new Solicitante(
                $fila['id_solicitante'], 
                $fila['nombre'], 
                $fila['apellido'], 
                $fila['curso'], 
                $fila['division'], 
                $fila['email'], 
                $fila['telefono']
            );
        }
        return $resultados;
    }
}
?>