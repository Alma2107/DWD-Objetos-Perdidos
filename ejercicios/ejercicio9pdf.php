<?php

class Temperatura {
    private $grados;

    
    public function setGrados($valor) {
        if ($valor < -273 || $valor > 1000) {
            throw new InvalidArgumentException("Error: La temperatura $valor °C está fuera del rango permitido (-273 a 1000).");
        }
        $this->grados = $valor;
    }

    public function getGrados() {
        return $this->grados;
    }
}

$clima = new Temperatura();


try {
    $clima->setGrados(25);
    echo "Temperatura establecida: " . $clima->getGrados() . "°C<br>";
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "<br>";
}


try {
    $clima->setGrados(-500); 
} catch (InvalidArgumentException $e) {
    echo "Capturado: " . $e->getMessage() . "<br>";
}


try {
    $clima->setGrados(5000);
} catch (InvalidArgumentException $e) {
    echo "Capturado: " . $e->getMessage() . "<br>";
}

?>