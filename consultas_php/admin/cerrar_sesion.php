<?php
//retomamos la sesion activa
//para saber cual tenemos que borrar
session_start();

//destruimos todos los datos
//para que se cierre la cuenta
session_destroy();

//lo llevamos a la pagina principal
//para que siga navegando normal
header('Location: ../../index.php');
exit;
?>