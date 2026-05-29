<?php
include_once 'Administrador.php';

class AdministradorDAO {
    private PDO $conexion;

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    public function login(string $usuario, string $password): bool {
        try {
            $sql = "SELECT password FROM administradores WHERE usuario = :usuario";
            $query = $this->conexion->prepare($sql);
            $query->execute([':usuario' => $usuario]);
            $resultado = $query->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                // Compara contraseñas usando el hash seguro de PHP
                return password_verify($password, $resultado['password']);
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}