<?php

class Libro {
    public $titulo;
    public $autor;
    public $anio;

    public function __construct($titulo, $autor, $anio) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anio = $anio;
    }

    
    public function __toString(): string {
        return "'{$this->titulo}' de {$this->autor} ({$this->anio})";
    }
}


$miLibro = new Libro("Rayuela", "Julio Cortázar", 1963);
$otroLibro = new Libro("Fundación", "Isaac Asimov", 1951);


echo "Libro 1: " . $miLibro . "<br>";
echo "Libro 2: " . $otroLibro;

?>