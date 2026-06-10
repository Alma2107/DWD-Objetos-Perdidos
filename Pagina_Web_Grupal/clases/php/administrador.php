<?php
class administrador {
    private $id_administrador;
    private $nombre;
    private $apellido;
    private $usuario;
    private $contrasena;
    private $email;
    private $fecha_registro;

    public function __construct($id_administrador = null, $nombre = "", $apellido = "", $usuario = "", $contrasena = "", $email = "", $fecha_registro = "") {
        $this->id_administrador = $id_administrador;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
        $this->email = $email;
        $this->fecha_registro = $fecha_registro;
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

    public function getApellido() { 
        return $this->apellido; 
        }
    public function setApellido($apellido) { 
        $this->apellido = $apellido; 
        }

    public function getUsuario() { 
        return $this->usuario; 
        }
    public function setUsuario($usuario) { 
        $this->usuario = $usuario; 
        }
    public function getContrasena() { 
        return $this->contrasena;      
    public function setContrasena($contrasena) { 
        $this->contrasena = $contrasena; 
        }

    public function getEmail() { 
        return $this->email; 
        }
    public function setEmail($email) { 
        $this->email = $email; 
        }

    public function getFechaRegistro() { 
        return $this->fecha_registro; 
        }
    public function setFechaRegistro($fecha_registro) { 
        $this->fecha_registro = $fecha_registro; 
        }

}
}
?>