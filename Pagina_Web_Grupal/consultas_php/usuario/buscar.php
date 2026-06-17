<?php
// Archivo: C:\xampp\htdocs\DWD-Objetos-Perdidos\Pagina_Web_Grupal\consultas_php\usuario\buscar.php
header('Content-Type: application/json; charset=utf-8');

try {
    // Subimos dos niveles de forma exacta para incluir la arquitectura requerida
    if (file_exists(__DIR__ . '/../../conexion.php')) {
        require_once __DIR__ . '/../../conexion.php';
        require_once __DIR__ . '/../../clases/php/Objeto.php'; 
        require_once __DIR__ . '/../../clases/daos/objetoDao.php';
    } else {
        throw new Exception("No se pudieron encontrar las dependencias en el servidor.");
    }

    // Instanciamos la conexión PDO
    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();

    if (!$db) {
        throw new Exception("Error al establecer la conexión con la base de datos.");
    }

    // Inicializamos nuestro DAO inyectándole la conexión
    $daoObjeto = new ObjetoDAO($db);

    // Capturamos los parámetros que envía el Script de JS mediante la URL
    $id_categoria = isset($_GET['id_categoria']) ? trim($_GET['id_categoria']) : '';
    $textoBusqueda = isset($_GET['texto']) ? trim($_GET['texto']) : '';

    // Ejecutamos la consulta usando el nuevo método del DAO
    $objetosFiltrados = $daoObjeto->buscarFiltrado($id_categoria, $textoBusqueda);

    // Mapeamos los objetos a un formato de array plano compatible con el JSON que espera JavaScript
    $jsonResponse = [];
    foreach ($objetosFiltrados as $obj) {
        $jsonResponse[] = [
            'id'          => $obj->getIdObjeto(),
            'nombre'      => $obj->getNombre(),
            'foto'        => $obj->getFoto(),
            'descripcion' => $obj->getDescripcion()
        ];
    }

    // Retornamos los datos codificados limpiamente en JSON
    echo json_encode($jsonResponse, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'mensaje' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>