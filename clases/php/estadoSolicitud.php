<?php
class EstadoSolicitud {
    private $id_estado_solicitud;
    private $nombre;
    private $descripcion;

    public function __construct($id_estado_solicitud = null, $nombre = "", $descripcion = "") {
        $this->id_estado_solicitud = $id_estado_solicitud;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function getIdEstadoSolicitud() { 
        return $this->id_estado_solicitud; 
    }
    public function setIdEstadoSolicitud($id_estado_solicitud) { 
        $this->id_estado_solicitud = $id_estado_solicitud; 
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