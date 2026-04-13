<?php

class Usuario {
    //Propiedades
    public $nombre;
    public $apellido;
    public $edad;
    
    public function __construct ($nombre, $apellido, $edad) {
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->edad = $edad;
    echo "Se ha creado un nuevo usuario.\n";
    
 }
public function mostrarInfo(){
    return "Nombre: $this->nombre, Apellido:$this->apellido, edad:$this->edad";
 }
}
$usuario1= new Usuario ("Andre" , "Insau" , 28);
echo $usuario1->mostrarInfo();
?>
