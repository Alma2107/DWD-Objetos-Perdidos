<?php
// Endpoint AJAX para procesar solicitudes: aprobar o eliminar
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

$action = $_POST['action'] ?? '';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(['ok' => false, 'error' => 'ID inválido']);
    exit;
}

try {
    $c = new Conexion();
    $db = $c->conectar();

    if ($action === 'approve') {
        $db->beginTransaction();
        // Cambiar estado a 'Aprobada' si existe el estado, si no usar id 3 por convención
        $stmt = $db->prepare('SELECT id_estado_solicitud, id_objeto FROM solicitud WHERE id_solicitud = ? LIMIT 1');
        $stmt->execute([$id]);
        $filaSol = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$filaSol) {
            echo json_encode(['ok' => false, 'error' => 'Solicitud no encontrada']);
            exit;
        }
        $idObjeto = (int)$filaSol['id_objeto'];

        $stmt = $db->prepare('SELECT id_estado_solicitud FROM estado_solicitud WHERE LOWER(nombre) = ? LIMIT 1');
        $stmt->execute(['aprobada']);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            $idEstado = (int)$fila['id_estado_solicitud'];
        } else {
            $idEstado = 3;
        }
        $stmt = $db->prepare('UPDATE solicitud SET id_estado_solicitud = ?, fecha_resolucion = ? WHERE id_solicitud = ?');
        $stmt->execute([$idEstado, date('Y-m-d'), $id]);

        // Marcar objeto como entregado si existe el estado correspondiente
        $stmt = $db->prepare('SELECT id_estado_objeto FROM estado_objeto WHERE LOWER(nombre) LIKE ? LIMIT 1');
        $stmt->execute(['%entreg%']);
        $filaE = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($filaE) {
            $idEstadoObj = (int)$filaE['id_estado_objeto'];
            $stmt = $db->prepare('UPDATE objeto SET id_estado_objeto = ? WHERE id_objeto = ?');
            $stmt->execute([$idEstadoObj, $idObjeto]);
        }

        $db->commit();
        echo json_encode(['ok' => true, 'action' => 'approve']);
        exit;
    }

    if ($action === 'delete') {
        // eliminar solicitud
        $stmt = $db->prepare('DELETE FROM solicitud WHERE id_solicitud = ?');
        $stmt->execute([$id]);
        echo json_encode(['ok' => true, 'action' => 'delete']);
        exit;
    }

    echo json_encode(['ok' => false, 'error' => 'Acción desconocida']);
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
