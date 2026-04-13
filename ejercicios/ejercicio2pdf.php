<?php

class Producto {
  private $nombre;
    private $precio;

    //Propiedades
   

 //Getter y setter
 public function getNombre(){
    return $this->nombre;


 }
  //Getter y setter
 public function getPrecio(){
    return $this->precio;

 }
 public function setNombre($nombre){
    $this->nombre = $nombre;
 }
 public function setPrecio($precio){
    $this->precio = $precio;
 }
}

//crear el objeto (instancia primero)
$obj = new Producto("Juan", 2500);

//Ahora si puedes usar lso metodos
$obj->setNombre("Juan");
$obj->setPrecio(2500);
echo "<br>";
echo $obj->getNombre();
echo "<br>";
echo $obj->getPrecio();
?>

