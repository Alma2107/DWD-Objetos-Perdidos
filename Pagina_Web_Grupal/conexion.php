<?php
// Archivo: conexion.php

class Conexion {
    private string $host = "localhost";
    private string $db_name = "tecnolohost"; // <- Mantenemos el nombre correcto de tu base de datos
    private string $username = "root";       // <- Usamos el usuario administrador por defecto de XAMPP
    private string $password = "";           // <- Sin contraseña (vacío), tal como viene configurado tu XAMPP
    public $conn = null;

    public function conectar() {
        if ($this->conn === null) {
            try {
                $opciones = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];
                
                $this->conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8", 
                    $this->username, 
                    $this->password,
                    $opciones
                );
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
                exit;
            }
        }
        return $this->conn;
    }
}
?>