<?php
class Solicitud 
{
    private int $id_solicitud;
    private int $id_objeto;
    private string $nombre;
    private string $apellido;
    private string $curso;
    private string $turno; 
    private string $email;
    private string $horario_retiro; 
    private bool $estado;

    public function __construct() 
    {
        $this->id_solicitud = 0;
        $this->id_objeto = 0;
        $this->nombre = "";
        $this->apellido = "";
        $this->curso = "";
        $this->turno = "Mañana";
        $this->email = "";
        $this->horario_retiro = "";
        $this->estado = false; 
    }

    public function getIdSolicitud(): int { return $this->id_solicitud; }
    public function setIdSolicitud(int $id_solicitud): void { $this->id_solicitud = $id_solicitud; }

    public function getIdObjeto(): int { return $this->id_objeto; }
    public function setIdObjeto(int $id_objeto): void { $this->id_objeto = $id_objeto; }

    public function getNombre(): string { return $this->nombre; }
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }

    public function getApellido(): string { return $this->apellido; }
    public function setApellido(string $apellido): void { $this->apellido = $apellido; }

    public function getCurso(): string { return $this->curso; }
    public function setCurso(string $curso): void { $this->curso = $curso; }

    public function getTurno(): string { return $this->turno; }
    public function setTurno(string $turno): void { $this->turno = $turno; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getHorarioRetiro(): string { return $this->horario_retiro; }
    public function setHorarioRetiro(string $horario_retiro): void { $this->horario_retiro = $horario_retiro; }

    public function getEstado(): bool { return $this->estado; }
    public function setEstado(bool $estado): void { $this->estado = $estado; }
}