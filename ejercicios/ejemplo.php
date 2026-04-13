<?php

class Persona {
    //Propiedades
    public $nombre;
    public $apellido;
    public $edad;
    protected $dni;

    private $tipoSangre;
    
    public function __construct ($nombre, $apellido, $edad) {
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->edad = $edad;
    
 }
 //Getter y setter
 public function getTipoSangre(){
    return $this->tipoSangre;

 }
 public function setTipoSangre($tipoSangre){
    $this->tipoSangre = $tipoSangre;
 }
}

//crear el objeto (instancia primero)
$obj = new Persona("Juan", "Perez", 25);

//Ahora si puedes usar lso metodos
$obj->setTipoSangre("RH+");
echo "<br>";
echo $obj->getTipoSangre();
?>
