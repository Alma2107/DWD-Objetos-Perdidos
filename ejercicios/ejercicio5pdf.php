<?php

class Vehiculo {
    public $marca;
    public $modelo;
    public $color;


    public function __construct($marca, $modelo, $color = "Blanco") {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->color = $color;
    }

 
    public function mostrarInfo() {
        echo "Vehículo: " . $this->marca . " " . $this->modelo . " | Color: " . $this->color . "<br>";
    }
}


$auto1 = new Vehiculo("Toyota", "Corolla");

// 2. Instancia CON color especificado
$auto2 = new Vehiculo("Ford", "Mustang", "Rojo");

// Mostramos los resultados
$auto1->mostrarInfo();
$auto2->mostrarInfo();

?>