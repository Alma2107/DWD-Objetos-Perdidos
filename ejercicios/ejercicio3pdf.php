<?php

class CuentaBancaria {
        private $saldo;

    public function __construct($saldoInicial) {
        $this->saldo = $saldoInicial;
    }

    // Método para sumar dinero al saldo
    public function depositar($monto) {
        if ($monto > 0) {
            $this->saldo += $monto;
            echo "Depositado: $" . $monto . "\n";
        } else {
            echo "El monto a depositar debe ser positivo.\n";
        }
    }

   
    public function retirar($monto) {
        if ($monto > $this->saldo) {
            echo "Error: Fondos insuficientes para retirar $" . $monto . "\n";
        } elseif ($monto <= 0) {
            echo "El monto a retirar debe ser positivo.\n";
        } else {
            $this->saldo -= $monto;
            echo "Retirado: $" . $monto . "\n";
        }
    }

    
    public function getSaldo() {
        return $this->saldo;
    }
}


$miCuenta = new CuentaBancaria(1000);
echo "Saldo inicial: $" . $miCuenta->getSaldo() . "\n";
echo "---------------------------\n";


$miCuenta->depositar(500); 


$miCuenta->retirar(200);   


$miCuenta->retirar(2000); 

echo "Saldo final disponible: $" . $miCuenta->getSaldo() . "\n";

?>