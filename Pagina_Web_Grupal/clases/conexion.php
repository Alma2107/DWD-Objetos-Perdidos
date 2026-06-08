<?php
class Conexion {
    private string $host = "localhost";
    private string $db_name = "tecnolost_db";
    private string $username = "root";
    private string $password = "";
    public $conn = null;

    public function conectar() {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        if (!$this->conn) {
            echo "Error de conexión: " . mysqli_connect_error();
        }

        return $this->conn;
    }
}