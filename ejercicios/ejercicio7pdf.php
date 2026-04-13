<?php

class Tarea {
    public $titulo;
    public $estado;


    public function __construct($titulo, $estado = 'pendiente') {
        $this->titulo = $titulo;
        $this->estado = $estado;
    }


    public function getEstado() {
        return $this->estado;
    }
}


$listadoTareas = [
    new Tarea("Comprar leche", "completada"),
    new Tarea("Estudiar PHP"), 
    new Tarea("Ir al gimnasio"),
    new Tarea("Lavar el auto", "completada")
];


function mostrarPendientes($tareas) {
    echo "Tareas Pendientes<br>";
    
    foreach ($tareas as $tarea) {
        if ($tarea->getEstado() === 'pendiente') {
            echo "- " . $tarea->titulo . "<br>";
        }
    }
}


mostrarPendientes($listadoTareas);

?>