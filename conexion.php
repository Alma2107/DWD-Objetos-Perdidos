<?php

class Conexion {
    private string $host = "localhost";
    private string $db_name = "tecnolost"; 
    private string $username = "root";       
    private string $password = "";        
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