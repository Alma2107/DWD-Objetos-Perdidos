<?php
include_once 'Solicitud.php';

class SolicitudDAO 
{
    private PDO $conexion;

    public function __construct(PDO $conexion) 
    {
        $this->conexion = $conexion;
    }

    public function insertar(Solicitud $solicitud): bool 
    {
        try {
            $sql = "INSERT INTO solicitud (id_objeto, nombre, apellido, curso, turno, email, horario_retiro, estado) 
                    VALUES (:id_objeto, :nombre, :apellido, :curso, :turno, :email, :horario_retiro, :estado)";
            
            $query = $this->conexion->prepare($sql);

            return $query->execute([
                ':id_objeto'      => $solicitud->getIdObjeto(),
                ':nombre'         => $solicitud->getNombre(),
                ':apellido'       => $solicitud->getApellido(),
                ':curso'          => $solicitud->getCurso(),
                ':turno'          => $solicitud->getTurno(),
                ':email'          => $solicitud->getEmail(),
                ':horario_retiro' => $solicitud->getHorarioRetiro(),
                ':estado'         => $solicitud->getEstado() 
            ]);
            
        } catch (PDOException $e) {
            return false;
        }
    }
}