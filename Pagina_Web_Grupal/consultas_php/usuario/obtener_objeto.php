<?php

header('Content-Type: application/json; charset=utf-8');

try {
    if (file_exists(__DIR__ . '/../../conexion.php')) {
        require_once __DIR__ . '/../../conexion.php';
        require_once __DIR__ . '/../../clases/php/objeto.php'; 
        require_once __DIR__ . '/../../clases/daos/objetoDao.php';
    } else {
        throw new Exception("Dependencias no encontradas.");
    }

    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();

    if (!$db) {
        throw new Exception("Error de conexión a la base de datos.");
    }

    $id = isset($_GET['id']) ? trim($_GET['id']) : '';

    if ($id === '' || !is_numeric($id)) {
        throw new Exception("ID de objeto no válido.");
    }


    $daoObjeto = new ObjetoDAO($db);
    $detalle = $daoObjeto->obtenerDetallePorId((int)$id);

    if (!$detalle) {
        http_response_code(404);
        echo json_encode(['error' => true, 'mensaje' => 'Objeto no encontrado.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $objeto = $detalle['objeto'];
    $foto = $objeto->getFoto();
    if ($foto) {
        $foto = preg_match('/^(uploads\/|img\/|https?:\/\/)/', $foto) ? $foto : 'uploads/' . $foto;
    } else {
        $foto = 'img/default.png';
    }

  
    $respuesta = [
        'id'               => $objeto->getIdObjeto(),
        'nombre'           => $objeto->getNombre(),
        'descripcion'      => $objeto->getDescripcion(),
        'color'            => $objeto->getColor(),
        'marca'            => $objeto->getMarca(),
        'fecha_encontrado' => $objeto->getFechaEncontrado(),
        'foto'             => $foto,
        'observaciones'    => $objeto->getObservaciones(),
        'categoria'        => $detalle['categoria'] ?: 'Sin categoria',
        'ubicacion'        => $detalle['ubicacion'] ?: 'Sin ubicacion registrada',
        'estado'           => $detalle['estado'] ?: 'En custodia'
    ];

    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'mensaje' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>
