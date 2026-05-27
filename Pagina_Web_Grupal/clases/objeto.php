<?php

class Objeto {
    private int $id, $estado;
    private string $nombre, $descripcion, $categoria, $fecha_agregado;

    public function __construct() 
    {
        $this->id = 0;
        $this->nombre = "";
        $this->descripcion = "";
        $this->categoria = "";
        $this->fecha_agregado = "";
        $this->estado = 0;
    }

    // Getters y Setters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getCategoria(): string {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): void {
        $this->categoria = $categoria;
    }

    public function getFechaEstado(): string {
        return $this->fecha_agregado;
    }

    public function setFechaEstado(string $fecha_agregado): void {
        $this->fecha_agregado = $fecha_agregado;
    }

    public function getEstado(): int {
        return $this->estado;
    }

    public function setEstado(int $estado): void {
        $this->estado = $estado;
    }
}

