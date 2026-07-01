<?php
interface dao {
    public function insertar($obj);
    
    public function modificar($obj);
    
    public function eliminar($id);
    
    public function obtenerPorId($id);
    
    public function listarTodos();
}
?>