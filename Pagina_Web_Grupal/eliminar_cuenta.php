<?php
include 'conexion.php';
session_start();

$dni = $_SESSION['usuario'];
mysqli_query($conexion, "DELETE FROM clientes WHERE dni = '$dni'");

session_destroy();
header("Location: login.php");
?>