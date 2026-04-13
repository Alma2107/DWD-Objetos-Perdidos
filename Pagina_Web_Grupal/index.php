<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Insertar objeto
if (isset($_POST['subir_objeto'])) {
    $nom = $_POST['nombre_obj'];
    $des = $_POST['desc_obj'];
    $img = $_POST['url_img'];
    $fec = date('Y-m-d');
    
    $sql = "INSERT INTO objetos_perdidos (nombre, descripcion, imagen_url, fecha_agregado, estado) 
            VALUES ('$nom', '$des', '$img', '$fec', 1)";
    mysqli_query($conexion, $sql);
}
?>

<h1>Panel de Objetos Perdidos</h1>
<a href="logout.php">Cerrar Sesión</a> | <a href="eliminar_cuenta.php" onclick="return confirm('¿Seguro?')">Eliminar Cuenta</a>

<form method="POST">
    <h3>Reportar Objeto</h3>
    <input type="text" name="nombre_obj" placeholder="¿Qué perdiste?" required>
    <textarea name="desc_obj" placeholder="Descripción"></textarea>
    <input type="text" name="url_img" placeholder="URL de la imagen">
    <button name="subir_objeto">Publicar</button>
</form>

<hr>

<h2>Lista de Objetos</h2>
<?php
$resultado = mysqli_query($conexion, "SELECT * FROM objetos_perdidos ORDER BY id_objeto DESC");
while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<div>";
    echo "<h4>" . $row['nombre'] . "</h4>";
    echo "<p>" . $row['descripcion'] . "</p>";
    echo "<img src='" . $row['imagen_url'] . "' width='100'>";
    echo "<small>Fecha: " . $row['fecha_agregado'] . "</small>";
    echo "</div><hr>";
}
?>