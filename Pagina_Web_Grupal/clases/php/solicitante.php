<?php
class solicitante {
    private $id_solicitante;
    private $nombre;
    private $apellido;
    private $curso;
    private $division;
    private $email;
    private $telefono;

    public function __construct($id_solicitante = null, $nombre = "", $apellido = "", $curso = "", $division = "", $email = "", $telefono = null) {
        $this->id_solicitante = $id_solicitante;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->curso = $curso;
        $this->division = $division;
        $this->email = $email;
        $this->telefono = $telefono;
    }

    public function getIdSolicitante() { 
        return $this->id_solicitante; 
    }
    public function setIdSolicitante($id_solicitante) { 
        $this->id_solicitante = $id_solicitante; 
    }

    public function getNombre() { 
        return $this->nombre; 
    }
    public function setNombre($nombre) { 
        $this->nombre = $nombre; 
    }

    public function getApellido() { 
        return $this->apellido; 
    }
    public function setApellido($apellido) { 
        $this->apellido = $apellido; 
    }

    public function getCurso() { 
        return $this->curso; 
    }
    public function setCurso($curso) { 
        $this->curso = $curso; 
    }

    public function getDivision() { 
        return $this->division; 
    }
    public function setDivision($division) { 
        $this->division = $division; 
    }

    public function getEmail() { 
        return $this->email; 
    }
    public function setEmail($email) { 
        $this->email = $email; 
    }

    public function getTelefono() { 
        return $this->telefono; 
    }
    public function setTelefono($telefono) { 
        $this->telefono = $telefono; 
    }
}
?>