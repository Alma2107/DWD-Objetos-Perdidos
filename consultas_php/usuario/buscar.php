<?php

header('Content-Type: application/json; charset=utf-8');

try {

    if (file_exists(__DIR__ . '/../../conexion.php')) {
        require_once __DIR__ . '/../../conexion.php';
        require_once __DIR__ . '/../../clases/php/Objeto.php'; 
        require_once __DIR__ . '/../../clases/daos/objetoDao.php';
    } else {
        throw new Exception("No se pudieron encontrar las dependencias en el servidor.");
    }

  
    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();

    if (!$db) {
        throw new Exception("Error al establecer la conexión con la base de datos.");
    }

   
    $daoObjeto = new ObjetoDAO($db);


    $id_categoria = isset($_GET['id_categoria']) ? trim($_GET['id_categoria']) : '';
    $textoBusqueda = isset($_GET['texto']) ? trim($_GET['texto']) : '';

   
    $objetosFiltrados = $daoObjeto->buscarFiltrado($id_categoria, $textoBusqueda);

   
    $jsonResponse = [];
    foreach ($objetosFiltrados as $obj) {
        $jsonResponse[] = [
            'id'          => $obj->getIdObjeto(),
            'nombre'      => $obj->getNombre(),
            'foto'        => $obj->getFoto(),
            'descripcion' => $obj->getDescripcion()
        ];
    }

   
    echo json_encode($jsonResponse, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'mensaje' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>