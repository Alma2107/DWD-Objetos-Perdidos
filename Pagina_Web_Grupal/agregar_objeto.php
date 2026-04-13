<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del usuario
$correo = $_SESSION['usuario'];
$user_query = mysqli_query($conexion, "SELECT nombre FROM clientes WHERE correo = '$correo'");
$user = mysqli_fetch_assoc($user_query);

// Obtener categorías
$categorias = mysqli_query($conexion, "SELECT * FROM categorias");

// Manejar el envío del formulario
if (isset($_POST['subir_objeto'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre_obj']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['desc_obj']);
    $id_categoria = (int)$_POST['categoria'];
    $imagen_url = mysqli_real_escape_string($conexion, $_POST['url_img']);
    $fecha = date('Y-m-d');

    $query = "INSERT INTO objetos_perdidos (nombre, descripcion, id_categoria, imagen_url, fecha_agregado, estado) VALUES ('$nombre', '$descripcion', $id_categoria, '$imagen_url', '$fecha', 1)";
    mysqli_query($conexion, $query);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Objeto Perdido</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header class="topbar">
    <h1>📦 Agregar Objeto Perdido</h1>
    <div class="nav-actions">
        <p>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?>!</p>
        <a href="index.php" class="btn">Volver</a>
        <a href="logout.php" class="btn">Cerrar Sesión</a>
    </div>
</header>

<section class="form-section">
    <form method="POST" class="form-pro">
        <h3>Reportar Objeto Perdido</h3>
        <input type="text" name="nombre_obj" placeholder="Nombre del objeto" required>
        <textarea name="desc_obj" placeholder="Descripción..." rows="3" required></textarea>
        <select name="categoria" required>
            <option value="">Seleccionar Categoría</option>
            <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                <option value="<?php echo $cat['id_categoria']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
            <?php } ?>
        </select>
        <input type="url" name="url_img" placeholder="URL de imagen (opcional)">
        <button type="submit" name="subir_objeto">Publicar</button>
    </form>
</section>

</body>
</html>