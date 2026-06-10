<?php
interface dao {
    public function insertar($obj): void;
    public function actualizar($obj): void;
    public function eliminar($id): void;
    public function buscarPorId($id);
    public function listar();
}
?> 