<?php
// Endpoint AJAX para procesar solicitudes: aprobar o eliminar

// 1. Desactivamos la salida de errores por pantalla para que no rompa el JSON
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

// 2. Iniciamos el buffer de salida para atrapar cualquier basura o espacio en blanco
ob_start(); 

require_once __DIR__ . '/../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_clean();
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

$action = $_POST['action'] ?? '';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    ob_clean();
    echo json_encode(['ok' => false, 'error' => 'ID inválido']);
    exit;
}

try {
    $c = new Conexion();
    $db = $c->conectar();

    if ($action === 'approve') {
        $db->beginTransaction();
        
        $stmt = $db->prepare('SELECT id_estado_solicitud, id_objeto FROM solicitud WHERE id_solicitud = ? LIMIT 1');
        $stmt->execute([$id]);
        $filaSol = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$filaSol) {
            throw new Exception('Solicitud no encontrada');
        }
        $idObjeto = (int)$filaSol['id_objeto'];

        $stmt = $db->prepare('SELECT id_estado_solicitud FROM estado_solicitud WHERE LOWER(nombre) = ? LIMIT 1');
        $stmt->execute(['aprobada']);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($fila) {
            $idEstado = (int)$fila['id_estado_solicitud'];
        } else {
            $stmtInsert = $db->prepare('INSERT INTO estado_solicitud (nombre, descripcion) VALUES (?, ?)');
            $stmtInsert->execute(['Aprobada', 'La solicitud ha sido verificada y aprobada.']);
            $idEstado = (int)$db->lastInsertId();
        }
        
        $stmt = $db->prepare('UPDATE solicitud SET id_estado_solicitud = ?, fecha_resolucion = ? WHERE id_solicitud = ?');
        $stmt->execute([$idEstado, date('Y-m-d'), $id]);

        $stmt = $db->prepare('SELECT id_estado_objeto FROM estado_objeto WHERE LOWER(nombre) LIKE ? LIMIT 1');
        $stmt->execute(['%entreg%']);
        $filaE = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($filaE) {
            $idEstadoObj = (int)$filaE['id_estado_objeto'];
        } else {
            $stmtInsertObj = $db->prepare('INSERT INTO estado_objeto (nombre, descripcion) VALUES (?, ?)');
            $stmtInsertObj->execute(['Entregado', 'El objeto ya fue devuelto a su dueño.']);
            $idEstadoObj = (int)$db->lastInsertId();
        }
        
        $stmt = $db->prepare('UPDATE objeto SET id_estado_objeto = ? WHERE id_objeto = ?');
        $stmt->execute([$idEstadoObj, $idObjeto]);

        $db->commit();
        
        // Limpiamos el buffer justo antes de imprimir el JSON exitoso
        ob_clean(); 
        echo json_encode(['ok' => true, 'action' => 'approve']);
        exit;
    }

    if ($action === 'delete') {
        $stmt = $db->prepare('DELETE FROM solicitud WHERE id_solicitud = ?');
        $stmt->execute([$id]);
        
        ob_clean();
        echo json_encode(['ok' => true, 'action' => 'delete']);
        exit;
    }

    throw new Exception('Acción desconocida');

} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    // Limpiamos el buffer antes de imprimir el JSON de error controlado
    ob_clean();
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    exit;
}