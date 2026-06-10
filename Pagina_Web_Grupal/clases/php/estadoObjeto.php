<?php
class estadoObjeto {
    private $id_estado_objeto;
    private $nombre;
    private $descripcion;

    public function __construct($id_estado_objeto = null, $nombre = "", $descripcion = "") {
        $this->id_estado_objeto = $id_estado_objeto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function getIdEstadoObjeto() { 
        return $this->id_estado_objeto; 
    }
    public function setIdEstadoObjeto($id_estado_objeto) { 
        $this->id_estado_objeto = $id_estado_objeto; 
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