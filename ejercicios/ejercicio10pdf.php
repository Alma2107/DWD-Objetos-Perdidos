<?php

class Usuario {
   
    private static int $cantidad = 0;
    public $nombre;

    public function __construct($nombre) {
        $this->nombre = $nombre;
        
       
        self::$cantidad++;
    }

    
    public static function getCantidad() {
        return self::$cantidad;
    }
}


echo "Cantidad inicial: " . Usuario::getCantidad() . "<br>";


$u1 = new Usuario("Alice");
$u2 = new Usuario("Bob");
$u3 = new Usuario("Charlie");

echo "Usuarios creados: " . Usuario::getCantidad() . "<br>";


$u4 = new Usuario("Diana");
echo "Nueva cantidad: " . Usuario::getCantidad();

?>