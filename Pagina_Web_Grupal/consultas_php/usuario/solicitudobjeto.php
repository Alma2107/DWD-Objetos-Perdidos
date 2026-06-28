<?php

header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'error' => true,
            'mensaje' => 'Metodo no permitido.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    require_once __DIR__ . '/../../conexion.php';
    require_once __DIR__ . '/../../clases/php/Solicitante.php';
    require_once __DIR__ . '/../../clases/php/Solicitud.php';
    require_once __DIR__ . '/../../clases/daos/solicitanteDao.php';
    require_once __DIR__ . '/../../clases/daos/solicitudDao.php';
    require_once __DIR__ . '/../../clases/daos/estadoSolicitudDao.php';
    require_once __DIR__ . '/../../clases/daos/objetoDao.php';

    $idObjeto = filter_input(INPUT_POST, 'id_objeto', FILTER_VALIDATE_INT);
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $curso = trim($_POST['curso'] ?? '');
    $division = trim($_POST['division'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $descripcionPropiedad = trim($_POST['descripcion_propiedad'] ?? '');
    $observaciones = trim($_POST['observaciones'] ?? '');

    $errores = [];

    if (!$idObjeto) {
        $errores[] = 'Selecciona un objeto valido.';
    }

    if ($nombre === '') {
        $errores[] = 'Ingresa tu nombre.';
    }

    if ($apellido === '') {
        $errores[] = 'Ingresa tu apellido.';
    }

    if ($curso === '') {
        $errores[] = 'Ingresa tu curso.';
    }

    if ($division === '') {
        $errores[] = 'Ingresa tu division.';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'Ingresa un email valido.';
    }

    if ($descripcionPropiedad === '') {
        $errores[] = 'Describe por que el objeto es tuyo.';
    }

    if (!empty($errores)) {
        http_response_code(422);
        echo json_encode([
            'error' => true,
            'mensaje' => implode(' ', $errores)
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();

    $objetoDao = new ObjetoDAO($db);
    $objeto = $objetoDao->obtenerPorId($idObjeto);

    if (!$objeto) {
        http_response_code(404);
        echo json_encode([
            'error' => true,
            'mensaje' => 'El objeto seleccionado no existe.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $db->beginTransaction();

    try {
        $solicitanteDao = new SolicitanteDAO($db);
        $solicitudDao = new SolicitudDAO($db);
        $estadoSolicitudDao = new EstadoSolicitudDAO($db);

        $solicitante = new Solicitante(
            null,
            $nombre,
            $apellido,
            $curso,
            $division,
            $email,
            $telefono !== '' ? $telefono : null
        );

        $idSolicitante = $solicitanteDao->insertarYObtenerId($solicitante);
        $estadoInicial = $estadoSolicitudDao->obtenerEstadoInicial();

        if (!$estadoInicial) {
            throw new Exception('No se pudo determinar el estado inicial de la solicitud.');
        }

        $solicitud = new Solicitud(
            null,
            $idSolicitante,
            $objeto->getIdObjeto(),
            $estadoInicial->getIdEstadoSolicitud(),
            $objeto->getIdAdministrador(),
            date('Y-m-d'),
            $descripcionPropiedad,
            null,
            $observaciones !== '' ? $observaciones : null
        );

        $idSolicitud = $solicitudDao->insertarYObtenerId($solicitud);

        $db->commit();

        echo json_encode([
            'error' => false,
            'mensaje' => 'Solicitud enviada correctamente. Guarda el numero de reclamo para consultar con administracion.',
            'id_solicitud' => $idSolicitud
        ], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'mensaje' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
