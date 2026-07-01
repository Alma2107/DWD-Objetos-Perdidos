<?php
//iniciamos la sesion de php
//para saber si alguien entro
session_start();

//nos fijamos si falta el usuario
//en los datos guardados
if (!isset($_SESSION['idAdmin'])) {
    
    //lo mandamos directo al login
    //porque no tiene permiso
    header('Location: ../consultas_php/admin/login.php');
    exit;
}
?>