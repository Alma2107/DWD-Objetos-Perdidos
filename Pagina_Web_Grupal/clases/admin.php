<?php
class Administrador {
    private int $id_admin;
    private string $usuario;
    private string $password;

    public function __construct() {
        $this->id_admin = 0;
        $this->usuario = "";
        $this->password = "";
    }

    public function getIdAdmin(): int { return $this->id_admin; }
    public function setIdAdmin(int $id): void { $this->id = $id; }

    public function getUsuario(): string { return $this->usuario; }
    public function setUsuario(string $usuario): void { $this->usuario = $usuario; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }
}