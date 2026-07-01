<?php
class Categoria {
    private $id_categoria;
    private $nombre;
    private $descripcion;

    public function __construct($id_categoria = null, $nombre = "", $descripcion = "") {
        $this->id_categoria = $id_categoria;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function getIdCategoria() { 
        return $this->id_categoria; 
    }
    public function setIdCategoria($id_categoria) { 
        $this->id_categoria = $id_categoria; 
    }

    public function getNombre() { 
        return $this->nombre; 
    }
    public function setNombre($nombre) { 
        $this->nombre = $nombre; 
    }

    public function getDescripcion() { 
        return $this->descripcion; 
    }
    public function setDescripcion($descripcion) { 
        $this->descripcion = $descripcion; 
    }
}
?>