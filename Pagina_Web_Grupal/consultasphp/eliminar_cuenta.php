<?php
include '../includes/conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$correo = $_SESSION['usuario'];
mysqli_query($conexion, "DELETE FROM clientes WHERE correo = '$correo'");

session_destroy();
header("Location: login.php");
?>