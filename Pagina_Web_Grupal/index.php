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

// Obtener categorías para filtro
$categorias = mysqli_query($conexion, "SELECT * FROM categorias");

// Filtro por categoría
$categoria_filtro = isset($_GET['categoria']) && $_GET['categoria'] != '' ? (int)$_GET['categoria'] : null;
$where = $categoria_filtro ? "WHERE op.id_categoria = $categoria_filtro" : "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objetos Perdidos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header class="topbar">
    <h1>📦 Objetos Perdidos</h1>
    <div class="nav-actions">
        <p>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?>!</p>
        <a href="agregar_objeto.php" class="btn">Agregar Objeto Perdido</a>
        <a href="logout.php" class="btn">Cerrar Sesión</a>
        <a href="eliminar_cuenta.php" class="btn danger"
           onclick="return confirm('¿Seguro que querés eliminar tu cuenta?')">
           Eliminar Cuenta
        </a>
    </div>
</header>

<section class="filtro">
    <form method="GET" style="text-align: center; margin: 20px 0;">
        <label for="categoria">Filtrar por categoría:</label>
        <select name="categoria" id="categoria">
            <option value="">Todas las categorías</option>
            <?php
            mysqli_data_seek($categorias, 0); // Reset pointer
            while ($cat = mysqli_fetch_assoc($categorias)) {
                $selected = $categoria_filtro == $cat['id_categoria'] ? 'selected' : '';
                echo "<option value='{$cat['id_categoria']}' $selected>" . htmlspecialchars($cat['nombre']) . "</option>";
            }
            ?>
        </select>
        <button type="submit" class="btn">Filtrar</button>
    </form>
</section>

<section class="lista">
    <h2>Objetos Perdidos</h2>

    <div class="grid-objetos">
        <?php
        $resultado = mysqli_query($conexion, "SELECT op.*, c.nombre as categoria FROM objetos_perdidos op JOIN categorias c ON op.id_categoria = c.id_categoria $where ORDER BY op.id_objeto DESC");

        if (mysqli_num_rows($resultado) > 0) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $imagen = !empty($row['imagen_url']) ? $row['imagen_url'] : 'https://via.placeholder.com/300x200';
        ?>

        <div class="card">
            <img src="<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
            <div class="card-body">
                <h4><?php echo htmlspecialchars($row['nombre']); ?></h4>
                <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                <p><strong>Categoría:</strong> <?php echo htmlspecialchars($row['categoria']); ?></p>
                <span class="fecha"><?php echo date("d/m/Y", strtotime($row['fecha_agregado'])); ?></span>
            </div>
        </div>

        <?php }} else { ?>
            <p class="vacio">No hay objetos en esta categoría 😢</p>
        <?php } ?>
    </div>
</section>

</body>
</html>