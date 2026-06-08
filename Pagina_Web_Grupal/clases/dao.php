<?php
interface dao 
{
    public function insertar($obj): void;
    public function actualizar($obj): void;
    public function eliminar($obj): void;
    public function buscarPorId(int $id);
    public function listar();
}