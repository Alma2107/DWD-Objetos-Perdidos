<?php
class Conexion {
    private string $host = "localhost";
    private string $db_name = "tecnolost_db"; // Cambia esto por el nombre real de tu base de datos
    private string $username = "root";        // Tu usuario de MySQL
    private string $password = "";            // Tu contraseña de MySQL
    public ?PDO $conn = null;

    public function conectar(): ?PDO {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8"); 
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}