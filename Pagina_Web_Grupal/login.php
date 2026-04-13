<?php
include 'conexion.php';
session_start();

// Registro de usuario
if (isset($_POST['registrar'])) {
    $dni = $_POST['dni'];
    $nom = $_POST['nombre'];
    $ape = $_POST['apellido'];
    $cor = $_POST['correo'];
    $con = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Seguridad ante todo

    $sql = "INSERT INTO clientes VALUES ('$dni', '$nom', '$ape', '$cor', '$con')";
    mysqli_query($conexion, $sql);
}

// Inicio de sesión
if (isset($_POST['ingresar'])) {
    $cor = $_POST['correo'];
    $con = $_POST['contrasena'];
    
    $res = mysqli_query($conexion, "SELECT * FROM clientes WHERE correo = '$cor'");
    $user = mysqli_fetch_assoc($res);

    if ($user && password_verify($con, $user['contrasena'])) {
        $_SESSION['usuario'] = $user['dni'];
        header("Location: index.php");
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<form method="POST">
    <h2>Registro</h2>
    <input type="number" name="dni" placeholder="DNI" required>
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellido" placeholder="Apellido" required>
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button name="registrar">Registrarse</button>
</form>

<form method="POST">
    <h2>Login</h2>
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button name="ingresar">Entrar</button>
</form>