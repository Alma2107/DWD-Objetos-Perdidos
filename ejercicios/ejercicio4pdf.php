<?php

class Calculadora {
    // Método estático
    public static function sumar($a, $b) {
        return $a + $b;
    }
}


$resultado = Calculadora::sumar(3, 4);

echo "El resultado de la suma es: " . $resultado;

?>