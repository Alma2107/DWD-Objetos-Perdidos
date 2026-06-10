<?php
class ubicacion {
    private $id_ubicacion;
    private $nombre;
    private $sector;
    private $descripcion;

    public function __construct($id_ubicacion = null, $nombre = "", $sector = "", $descripcion = null) {
        $this->id_ubicacion = $id_ubicacion;
        $this->nombre = $nombre;
        $this->sector = $sector;
        $this->descripcion = $descripcion;
    }

    public function getIdUbicacion() { 
        return $this->id_ubicacion; 
    }
    public function setIdUbicacion($id_ubicacion) { 
        $this->id_ubicacion = $id_ubicacion; 
    }

    public function getNombre() { 
        return $this->nombre; 
    }
    public function setNombre($nombre) { 
        $this->nombre = $nombre; 
    }

    public function getSector() { 
        return $this->sector; 
    }
    public function setSector($sector) { 
        $this->sector = $sector; 
    }

    public function getDescripcion() { 
        return $this->descripcion; 
    }
    public function setDescripcion($descripcion) { 
        $this->descripcion = $descripcion; 
    }
}
?>