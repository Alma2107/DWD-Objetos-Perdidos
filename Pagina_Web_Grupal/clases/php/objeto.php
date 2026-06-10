<?php
class objeto {
    private $id_objeto;
    private $id_categoria;
    private $id_ubicacion;
    private $id_estado_objeto;
    private $id_administrador;
    private $nombre;
    private $descripcion;
    private $color;
    private $marca;
    private $fecha_encontrado;
    private $fecha_registro;
    private $foto;
    private $observaciones;

    public function __construct($id_objeto = null, $id_categoria = null, $id_ubicacion = null, $id_estado_objeto = null, $id_administrador = null, $nombre = "", $descripcion = "", $color = null, $marca = null, $fecha_encontrado = "", $fecha_registro = "", $foto = null, $observaciones = null) {
        $this->id_objeto = $id_objeto;
        $this->id_categoria = $id_categoria;
        $this->id_ubicacion = $id_ubicacion;
        $this->id_estado_objeto = $id_estado_objeto;
        $this->id_administrador = $id_administrador;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->color = $color;
        $this->marca = $marca;
        $this->fecha_encontrado = $fecha_encontrado;
        $this->fecha_registro = $fecha_registro;
        $this->foto = $foto;
        $this->observaciones = $observaciones;
    }

    public function getIdObjeto() { 
        return $this->id_objeto; 
    }
    public function setIdObjeto($id_objeto) { 
        $this->id_objeto = $id_objeto; 
    }

    public function getIdCategoria() { 
        return $this->id_categoria; 
    }
    public function setIdCategoria($id_categoria) { 
        $this->id_categoria = $id_categoria; 
    }

    public function getIdUbicacion() { 
        return $this->id_ubicacion; 
    }
    public function setIdUbicacion($id_ubicacion) { 
        $this->id_ubicacion = $id_ubicacion; 
    }

    public function getIdEstadoObjeto() { 
        return $this->id_estado_objeto; 
    }
    public function setIdEstadoObjeto($id_estado_objeto) { 
        $this->id_estado_objeto = $id_estado_objeto; 
    }

    public function getIdAdministrador() { 
        return $this->id_administrador; 
    }
    public function setIdAdministrador($id_administrador) { 
        $this->id_administrador = $id_administrador; 
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

    public function getColor() { 
        return $this->color; 
    }
    public function setColor($color) { 
        $this->color = $color; 
    }

    public function getMarca() { 
        return $this->marca; 
    }
    public function setMarca($marca) { 
        $this->marca = $marca; 
    }

    public function getFechaEncontrado() { 
        return $this->fecha_encontrado; 
    }
    public function setFechaEncontrado($fecha_encontrado) { 
        $this->fecha_encontrado = $fecha_encontrado; 
    }

    public function getFechaRegistro() { 
        return $this->fecha_registro; 
    }
    public function setFechaRegistro($fecha_registro) { 
        $this->fecha_registro = $fecha_registro; 
    }

    public function getFoto() { 
        return $this->foto; 
    }
    public function setFoto($foto) { 
        $this->foto = $foto; 
    }

    public function getObservaciones() { 
        return $this->observaciones; 
    }
    public function setObservaciones($observaciones) { 
        $this->observaciones = $observaciones; 
    }
}
?>