<?php
// Archivo: C:\xampp\htdocs\DWD-Objetos-Perdidos\Pagina_Web_Grupal\consultas_php\usuario\buscar.php
header('Content-Type: application/json; charset=utf-8');

try {
    // Usamos __DIR__ para subir de manera exacta 2 niveles hasta la raíz donde está conexion.php
    if (file_exists(__DIR__ . '/../../conexion.php')) {
        require_once __DIR__ . '/../../conexion.php';
    } else {
        throw new Exception("No se pudo encontrar el archivo de conexión en la raíz.");
    }

    // Instanciamos y conectamos con PDO
    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();

    if (!$db) {
        throw new Exception("Error al establecer la conexión con la base de datos.");
    }

    // Capturamos el id de la categoría enviado por la URL
    $id_categoria = isset($_GET['id_categoria']) ? trim($_GET['id_categoria']) : '';

    // Validamos si es una categoría numérica concreta o si se pidió "Todas"
    if ($id_categoria !== '' && is_numeric($id_categoria)) {
        $sql = "SELECT * FROM objeto WHERE id_categoria = :id_categoria ORDER BY fecha_registro DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id_categoria' => (int)$id_categoria]);
    } else {
        $sql = "SELECT * FROM objeto ORDER BY fecha_registro DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados === false) {
        $resultados = [];
    }

    // Retornamos los datos codificados en JSON
    echo json_encode($resultados, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'mensaje' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>