<?php
class Administrador {
    private int $id_admin;
    private string $usuario;
    private string $contrasena;

    public function __construct() {
        $this->id_admin = 0;
        $this->usuario = "";
        $this->contrasena = "";
    }

    public function getIdAdmin(){ 
        return $this->id_admin; 
        }
    public function setIdAdmin(int $id){ 
        $this->id_admin = $id; 
        }

    public function getUsuario(){ 
        return $this->usuario; 
        }
    public function setUsuario(string $usuario){ 
        $this->usuario = $usuario; 
        }

    public function getContrasena(){ 
        return $this->contrasena; 
        }
    public function setContrasena(string $contrasena){ 
        $this->contrasena = $contrasena; 
        }
}