<?php
class Solicitud {
    private $id_solicitud;
    private $id_solicitante;
    private $id_objeto;
    private $id_estado_solicitud;
    private $id_administrador;
    private $fecha_solicitud;
    private $descripcion_propiedad;
    private $fecha_resolucion;
    private $observaciones;

    public function __construct($id_solicitud = null, $id_solicitante = null, $id_objeto = null, $id_estado_solicitud = null, $id_administrador = null, $fecha_solicitud = "", $descripcion_propiedad = "", $fecha_resolucion = null, $observaciones = null) {
        $this->id_solicitud = $id_solicitud;
        $this->id_solicitante = $id_solicitante;
        $this->id_objeto = $id_objeto;
        $this->id_estado_solicitud = $id_estado_solicitud;
        $this->id_administrador = $id_administrador;
        $this->fecha_solicitud = $fecha_solicitud;
        $this->descripcion_propiedad = $descripcion_propiedad;
        $this->fecha_resolucion = $fecha_resolucion;
        $this->observaciones = $observaciones;
    }

    public function getIdSolicitud() { return $this->id_solicitud; }
    public function setIdSolicidut($id_solicitud) { $this->id_solicitud = $id_solicitud; }

    public function getIdSolicitante() { return $this->id_solicitante; }
    public function setIdSolicitante($id_solicitante) { $this->id_solicitante = $id_solicitante; }

    public function getIdObjeto() { return $this->id_objeto; }
    public function setIdObjeto($id_objeto) { $this->id_objeto = $id_objeto; }

    public function getIdEstadoSolicitud() { return $this->id_estado_solicitud; }
    public function setIdEstadoSolicitud($id_estado_solicitud) { $this->id_estado_solicitud = $id_estado_solicitud; }

    public function getIdAdministrador() { return $this->id_administrador; }
    public function setIdAdministrador($id_administrador) { $this->id_administrador = $id_administrador; }

    public function getFechaSolicitud() { return $this->fecha_solicitud; }
    public function setFechaSolicitud($fecha_solicitud) { $this->fecha_solicitud = $fecha_solicitud; }

    public function getDescripcionPropiedad() { return $this->descripcion_propiedad; }
    public function setDescripcionPropiedad($descripcion_propiedad) { $this->descripcion_propiedad = $descripcion_propiedad; }

    public function getFechaResolucion() { return $this->fecha_resolucion; }
    public function setFechaResolucion($fecha_resolucion) { $this->fecha_resolucion = $fecha_resolucion; }

    public function getObservaciones() { return $this->observaciones; }
    public function setObservaciones($observaciones) { $this->observaciones = $observaciones; }
}
?>