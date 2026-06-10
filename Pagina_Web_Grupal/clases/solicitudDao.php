<?php
include_once 'peticion.php';
include_once 'dao.php';
include_once 'conexion.php';

class peticiondao implements dao{
    private $conexion;

    public function __construct() {
        $conexion = new Conexion();
        $this->conexion = $conexion->conectar();
    }

    public function insertar($obj): void{

    }

    public function actualizar($obj): void{
        
    }

    public function eliminar($obj): void{
        
    }

    public function buscarPorId(int $id){
        
    }

    public function listar($obj){
        
    }

}

