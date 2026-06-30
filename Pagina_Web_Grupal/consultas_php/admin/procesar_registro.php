<?php
session_start();

require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/../../clases/php/Objeto.php';
require_once __DIR__ . '/../../clases/daos/objetoDao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../panel_admin/admin_registrar.php');
    exit;
}

try {
    $conexionInstancia = new Conexion();
    $db = $conexionInstancia->conectar();
    $daoObjeto = new ObjetoDAO($db);

    $nombre = trim($_POST['nombre'] ?? '');
    $categoriaTexto = trim($_POST['categoria_texto'] ?? '');
    $ubicacionTexto = trim($_POST['ubicacion_texto'] ?? '');
    $estadoTexto = trim($_POST['estado_seleccionado'] ?? '');
    $fechaEncontrado = trim($_POST['fecha_encontrado'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $color = trim($_POST['color'] ?? '');
    $observaciones = trim($_POST['observaciones'] ?? '');

    if ($nombre === '' || $categoriaTexto === '' || $ubicacionTexto === '' || $estadoTexto === '' || $fechaEncontrado === '' || $descripcion === '') {
        throw new Exception('Completa todos los campos obligatorios.');
    }

    $db->beginTransaction();

    try {
        $idCategoria = obtenerOCrearCategoria($db, $categoriaTexto);
        $idUbicacion = obtenerOCrearUbicacion($db, $ubicacionTexto);
        $idEstadoObjeto = obtenerOCrearEstadoObjeto($db, $estadoTexto);
        $idAdministrador = obtenerAdministrador($db);
        $nombreArchivo = guardarFotoSubida();

        $nuevoObjeto = new Objeto(
            null,
            $idCategoria,
            $idUbicacion,
            $idEstadoObjeto,
            $idAdministrador,
            $nombre,
            $descripcion,
            $color !== '' ? $color : null,
            $marca !== '' ? $marca : null,
            $fechaEncontrado,
            date('Y-m-d'),
            $nombreArchivo,
            $observaciones !== '' ? $observaciones : null
        );

        $daoObjeto->insertar($nuevoObjeto);
        $db->commit();

        header('Location: ../../panel_admin/admin_registrar.php?exito=1');
        exit;
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
} catch (Exception $e) {
    header('Location: ../../panel_admin/admin_registrar.php?error=' . urlencode($e->getMessage()));
    exit;
}

function obtenerOCrearCategoria(PDO $db, string $nombre): int {
    $stmt = $db->prepare('SELECT id_categoria FROM categoria WHERE nombre = ? LIMIT 1');
    $stmt->execute([$nombre]);
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        return (int)$fila['id_categoria'];
    }

    $stmt = $db->prepare('INSERT INTO categoria (nombre, descripcion) VALUES (?, ?)');
    $stmt->execute([$nombre, 'Categoria registrada desde el panel admin.']);
    return (int)$db->lastInsertId();
}

function obtenerOCrearUbicacion(PDO $db, string $nombre): int {
    $stmt = $db->prepare('SELECT id_ubicacion FROM ubicacion WHERE nombre = ? LIMIT 1');
    $stmt->execute([$nombre]);
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        return (int)$fila['id_ubicacion'];
    }

    $stmt = $db->prepare('INSERT INTO ubicacion (nombre, sector, descripcion) VALUES (?, ?, ?)');
    $stmt->execute([$nombre, 'General', 'Ubicacion registrada desde el panel admin.']);
    return (int)$db->lastInsertId();
}

function obtenerOCrearEstadoObjeto(PDO $db, string $nombre): int {
    $stmt = $db->prepare('SELECT id_estado_objeto FROM estado_objeto WHERE nombre = ? LIMIT 1');
    $stmt->execute([$nombre]);
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        return (int)$fila['id_estado_objeto'];
    }

    $stmt = $db->prepare('INSERT INTO estado_objeto (nombre, descripcion) VALUES (?, ?)');
    $stmt->execute([$nombre, 'Estado registrado desde el panel admin.']);
    return (int)$db->lastInsertId();
}

function obtenerAdministrador(PDO $db): int {
    if (!empty($_SESSION['id_administrador'])) {
        $stmt = $db->prepare('SELECT id_administrador FROM administrador WHERE id_administrador = ? LIMIT 1');
        $stmt->execute([(int)$_SESSION['id_administrador']]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            return (int)$fila['id_administrador'];
        }
    }

    $stmt = $db->query('SELECT id_administrador FROM administrador ORDER BY id_administrador ASC LIMIT 1');
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        return (int)$fila['id_administrador'];
    }

    $stmt = $db->prepare('INSERT INTO administrador (nombre, apellido, usuario, contrasena, email, fecha_registro) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute(['Admin', 'Sistema', 'admin', 'admin', 'admin@tecnolost.local', date('Y-m-d')]);
    return (int)$db->lastInsertId();
}

function guardarFotoSubida(): string {
    if (!isset($_FILES['imagen_objeto']) || $_FILES['imagen_objeto']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Subi una foto del objeto.');
    }

    $archivo = $_FILES['imagen_objeto'];
    $maxBytes = 5 * 1024 * 1024;

    if ($archivo['size'] > $maxBytes) {
        throw new Exception('La foto no puede superar los 5 MB.');
    }

    $infoImagen = getimagesize($archivo['tmp_name']);
    if ($infoImagen === false) {
        throw new Exception('El archivo subido no es una imagen valida.');
    }

    $tiposPermitidos = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_WEBP => 'webp',
        IMAGETYPE_GIF => 'gif'
    ];

    $tipoImagen = $infoImagen[2];
    if (!isset($tiposPermitidos[$tipoImagen])) {
        throw new Exception('La foto debe ser JPG, PNG, WEBP o GIF.');
    }

    $carpetaUploads = __DIR__ . '/../../uploads/';
    if (!is_dir($carpetaUploads) && !mkdir($carpetaUploads, 0775, true)) {
        throw new Exception('No se pudo crear la carpeta de fotos.');
    }

    $extension = $tiposPermitidos[$tipoImagen];
    $nombreSeguro = 'objeto_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
    $destino = $carpetaUploads . $nombreSeguro;

    if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
        throw new Exception('No se pudo guardar la foto del objeto.');
    }

    return $nombreSeguro;
}
?>
