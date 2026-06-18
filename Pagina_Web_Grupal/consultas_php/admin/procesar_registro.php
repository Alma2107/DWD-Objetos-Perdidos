<?php
session_start();
require_once '../../conexion.php';
require_once '../../clases/php/objeto.php';
require_once '../../clases/daos/objetoDao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conexionInstancia = new Conexion();
        $db = $conexionInstancia->conectar();
        $daoObjeto = new ObjetoDAO($db);

        $nombre = trim($_POST['nombre']);
        $categoria_texto = trim($_POST['categoria_texto']);
        $ubicacion_texto = trim($_POST['ubicacion_texto']);
        $fecha_encontrado = $_POST['fecha_encontrado'];
        $marca = !empty(trim($_POST['marca'])) ? trim($_POST['marca']) : null;
        $color = !empty(trim($_POST['color'])) ? trim($_POST['color']) : null;
        $descripcion = !empty(trim($_POST['descripcion'])) ? trim($_POST['descripcion']) : null;
        $observaciones = !empty(trim($_POST['observaciones'])) ? trim($_POST['observaciones']) : null;

        // Procesar Categoría
        $stmtCat = $db->prepare("SELECT id_categoria FROM categoria WHERE nombre = ?");
        $stmtCat->execute([$categoria_texto]);
        $resCat = $stmtCat->fetch(PDO::FETCH_ASSOC);
        $id_categoria = $resCat ? (int)$resCat['id_categoria'] : ($db->prepare("INSERT INTO categoria (nombre) VALUES (?)")->execute([$categoria_texto]) ? (int)$db->lastInsertId() : 1);

        // Procesar Ubicación
        $stmtUbi = $db->prepare("SELECT id_ubicacion FROM ubicacion WHERE nombre = ?");
        $stmtUbi->execute([$ubicacion_texto]);
        $resUbi = $stmtUbi->fetch(PDO::FETCH_ASSOC);
        $id_ubicacion = $resUbi ? (int)$resUbi['id_ubicacion'] : ($db->prepare("INSERT INTO ubicacion (nombre, sector) VALUES (?, '')")->execute([$ubicacion_texto]) ? (int)$db->lastInsertId() : 1);

        // Procesar Estado
        $estado_form = $_POST['estado_seleccionado'];
        $stmtEst = $db->prepare("SELECT id_estado_objeto FROM estado_objeto WHERE nombre = ?");
        $stmtEst->execute([$estado_form]);
        $resEst = $stmtEst->fetch(PDO::FETCH_ASSOC);
        $id_estado_objeto = $resEst ? (int)$resEst['id_estado_objeto'] : ($db->prepare("INSERT INTO estado_objeto (nombre) VALUES (?)")->execute([$estado_form]) ? (int)$db->lastInsertId() : 1);

        // Procesar Admin
        $id_administrador = isset($_SESSION['id_administrador']) ? (int)$_SESSION['id_administrador'] : 1;

        // PROCESAMIENTO DE IMAGEN (Archivo físico)
        $nombre_archivo = null;
        if (isset($_FILES['imagen_objeto']) && $_FILES['imagen_objeto']['error'] === UPLOAD_ERR_OK) {
            $carpeta_uploads = '../../uploads/';
            if (!file_exists($carpeta_uploads)) mkdir($carpeta_uploads, 0777, true);
            $nombre_archivo = time() . '_' . basename($_FILES['imagen_objeto']['name']);
            move_uploaded_file($_FILES['imagen_objeto']['tmp_name'], $carpeta_uploads . $nombre_archivo);
        }

        $nuevoObjeto = new Objeto(null, $id_categoria, $id_ubicacion, $id_estado_objeto, $id_administrador, $nombre, $descripcion, $color, $marca, $fecha_encontrado, date('Y-m-d'), $nombre_archivo, $observaciones);
        $daoObjeto->insertar($nuevoObjeto);

        header('Location: ../../panel_admin/admin_registrar.php?exito=1');
        exit;
    } catch (Exception $e) {
        header('Location: ../../panel_admin/admin_registrar.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}
?>