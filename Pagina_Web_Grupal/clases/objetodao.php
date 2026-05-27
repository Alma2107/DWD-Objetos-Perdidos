<?php
include_once 'objeto.php';

class ObjetoDAO 
{
    private PDO $conexion;

    // El constructor recibe la conexión PDO a la base de datos
    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    public function insertar(Objeto $objeto): bool {
        try {
            $sql = "INSERT INTO objetos (nombre, descripcion, categoria, fecha_agregado, estado) 
                    VALUES (:nombre, :descripcion, :categoria, :fecha_agregado, :estado)";
            
            $query = $this->conexion->prepare($sql);

            return $query->execute([
                ':nombre'         => $objeto->getNombre(),
                ':descripcion'    => $objeto->getDescripcion(),
                ':categoria'      => $objeto->getCategoria(),
                ':fecha_agregado' => $objeto->getFechaEstado(), 
                ':estado'         => $objeto->getEstado()
            ]);
            
        } catch (PDOException $e) {
            return false;
        }
    }

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    public function modificar(Objeto $objeto): bool {
        try {
            $sql = "UPDATE objetos SET nombre = :nombre, descripcion = :descripcion, categoria = :categoria, fecha_agregado = :fecha_agregado, estado = :estado WHERE id = :id";
            
            $query = $this->conexion->prepare($sql);

            return $query->execute([
                ':nombre'         => $objeto->getNombre(),
                ':descripcion'    => $objeto->getDescripcion(),
                ':categoria'      => $objeto->getCategoria(),
                ':fecha_agregado' => $objeto->getFechaEstado(), 
            ]);
            
        } catch (PDOException $e) {
            return false;
        }
    } 

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    public function estado(Objeto $objeto): bool {
        try {
            $sql = "UPDATE objetos SET estado = :estado WHERE id = :id";
            
            $query = $this->conexion->prepare($sql);

            return $query->execute([  
                ':estado'         => $objeto->getEstado(),
            ]);
            
        } catch (PDOException $e) {
            return false;
        }
    }
}