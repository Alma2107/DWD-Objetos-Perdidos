<?php
require_once 'dao.php';
require_once '../php/administrador.php';
require_once '../conexion.php'; 

class administradorDAO implements DAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($admin) {
        $sql = "INSERT INTO administrador (nombre, apellido, usuario, contrasena, email, fecha_registro) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $admin->getNombre(), 
            $admin->getApellido(), 
            $admin->getUsuario(), 
            $admin->getContrasena(), 
            $admin->getEmail(), 
            $admin->getFechaRegistro()
        ]);
    }

    public function modificar($admin) {
        $sql = "UPDATE administrador SET nombre = ?, apellido = ?, usuario = ?, contrasena = ?, email = ? WHERE id_administrador = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $admin->getNombre(), 
            $admin->getApellido(), 
            $admin->getUsuario(), 
            $admin->getContrasena(), 
            $admin->getEmail(), 
            $admin->getIdAdministrador()
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM administrador WHERE id_administrador = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM administrador WHERE id_administrador = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new Administrador(
                $fila['id_administrador'], 
                $fila['nombre'], 
                $fila['apellido'], 
                $fila['usuario'], 
                $fila['contrasena'], 
                $fila['email'], 
                $fila['fecha_registro']
            );
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM administrador";
        $stmt = $this->conexion->query($sql);
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new Administrador(
                $fila['id_administrador'], 
                $fila['nombre'], 
                $fila['apellido'], 
                $fila['usuario'], 
                $fila['contrasena'], 
                $fila['email'], 
                $fila['fecha_registro']
            );
        }
        return $resultados;
    }

    public function login($usuario, $contrasena) {
        $sql = "SELECT * FROM administrador WHERE usuario = ? AND contrasena = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario, $contrasena]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new Administrador(
                $fila['id_administrador'], 
                $fila['nombre'], 
                $fila['apellido'], 
                $fila['usuario'], 
                $fila['contrasena'], 
                $fila['email'], 
                $fila['fecha_registro']
            );
        }
        return null;
    }
}
?> 