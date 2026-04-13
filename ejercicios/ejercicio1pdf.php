<?php

class Persona {
    
    public $nombre;
    public $edad;

   
    public function __construct($nombre, $edad) {
        $this->nombre = $nombre;
        $this->edad = $edad;
    }
}


$persona1 = new Persona("Julieta", 28);

// 2. Instanciamos el segundo objeto
$persona2 = new Persona("Marcos", 35);


echo "Persona 1: " . $persona1->nombre . " tiene " . $persona1->edad . " años.<br>";
echo "Persona 2: " . $persona2->nombre . " tiene " . $persona2->edad . " años.";

?>