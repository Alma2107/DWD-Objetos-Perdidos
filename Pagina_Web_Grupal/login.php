<?php
include 'conexion.php';
session_start();

// Si ya está logueado → lo manda al index
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// REGISTRO
if (isset($_POST['registrar'])) {
    $nom = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $ape = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $cor = mysqli_real_escape_string($conexion, $_POST['correo']);
    $con = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    mysqli_query($conexion, "INSERT INTO clientes (nombre, apellido, correo, contrasena) 
                            VALUES ('$nom','$ape','$cor','$con')");

    $_SESSION['usuario'] = $cor;

    header("Location: index.php");
    exit();
}

// LOGIN
if (isset($_POST['ingresar'])) {
    $cor = mysqli_real_escape_string($conexion, $_POST['correo']);
    $con = $_POST['contrasena'];

    $res = mysqli_query($conexion, "SELECT * FROM clientes WHERE correo='$cor'");
    $user = mysqli_fetch_assoc($res);

    if ($user && password_verify($con, $user['contrasena'])) {
        $_SESSION['usuario'] = $user['correo'];

        header("Location: index.php");
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Objetos Perdidos</title>
    <link rel="stylesheet" href="estilos-login.css">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST">
                <h1>Crear Cuenta</h1>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="text" name="apellido" placeholder="Apellido" required>
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button type="submit" name="registrar">Registrarse</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="POST">
                <h1>Iniciar Sesión</h1>
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button type="submit" name="ingresar">Ingresar</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>¡Bienvenido de vuelta!</h1>
                    <p>Para mantenerte conectado con nosotros, inicia sesión con tu información personal</p>
                    <button class="ghost" id="signIn">Iniciar Sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>¡Hola, amigo!</h1>
                    <p>Ingresa tus datos personales y comienza tu viaje con nosotros</p>
                    <button class="ghost" id="signUp">Registrarse</button>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>