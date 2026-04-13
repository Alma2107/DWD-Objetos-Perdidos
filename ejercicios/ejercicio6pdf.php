<?php

class Estudiante {
    public $nombre;
    public $promedio;

    public function __construct($nombre, $promedio) {
        $this->nombre = $nombre;
        $this->promedio = $promedio;
    }

   
    public function getPromedio() {
        return $this->promedio;
    }
}


function compararEstudiantes($est1, $est2) {
    if ($est1->getPromedio() > $est2->getPromedio()) {
        return $est1;
    } else {
        return $est2;
    }
}


$e1 = new Estudiante("Lucía", 9.2);
$e2 = new Estudiante("Pedro", 7.5);
$e3 = new Estudiante("Sofía", 9.5);


$ganador1 = compararEstudiantes($e1, $e2);
echo "Entre " . $e1->nombre . " y " . $e2->nombre . ", el mejor promedio es de: " . $ganador1->nombre . " (" . $ganador1->promedio . ")<br>";


$ganadorFinal = compararEstudiantes($ganador1, $e3);
echo "El estudiante con el promedio más alto de todos es: **" . $ganadorFinal->nombre . "** con un " . $ganadorFinal->promedio;

?>