<?php

class Conexion {
    private string $host = "5.180.151.26";
    private string $db_name = "objetos_perdidos"; 
    private string $username = "perdidos_user";       
    private string $password = "ProyectoPerdidosCarena26!";        
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