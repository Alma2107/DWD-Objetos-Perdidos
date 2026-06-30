<?php
require_once __DIR__ . '/../conexion.php';

$objetos = [];
$error = null;

try {
    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();
    $sql = "SELECT
                o.id_objeto,
                o.nombre,
                o.descripcion,
                o.color,
                o.marca,
                o.fecha_encontrado,
                o.fecha_registro,
                o.foto,
                c.nombre AS categoria,
                u.nombre AS ubicacion,
                u.sector,
                eo.nombre AS estado
            FROM objeto o
            INNER JOIN categoria c ON o.id_categoria = c.id_categoria
            INNER JOIN ubicacion u ON o.id_ubicacion = u.id_ubicacion
            INNER JOIN estado_objeto eo ON o.id_estado_objeto = eo.id_estado_objeto
            WHERE LOWER(eo.nombre) LIKE '%devuelto%'
               OR LOWER(eo.nombre) LIKE '%entregado%'
            ORDER BY o.fecha_registro DESC, o.id_objeto DESC";
    $objetos = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = $e->getMessage();
}

function fotoAdmin($foto) {
    if (!$foto) {
        return '../img/default.png';
    }

    if (preg_match('/^(https?:\/\/|\/)/', $foto)) {
        return $foto;
    }

    if (strpos($foto, 'uploads/') === 0 || strpos($foto, 'img/') === 0) {
        return '../' . $foto;
    }

    return '../uploads/' . $foto;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Entregados</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin/panel-admin-estilo.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="brand">
                <i class="fa-solid fa-magnifying-glass-location"></i>
                <div>
                    <h1>TECNOLOST</h1>
                    <span>ADMIN PANEL</span>
                </div>
            </div>
            <nav class="nav-menu">
                <a href="admin_panel.php" class="nav-btn"><i class="fa-solid fa-chart-pie"></i>Inicio</a>
                <a href="admin_registrar.php" class="nav-btn"><i class="fa-solid fa-plus-circle"></i>Registrar</a>
                <a href="admin_solicitudes.php" class="nav-btn"><i class="fa-solid fa-inbox"></i>Solicitudes</a>
                <a href="admin_inventario.php" class="nav-btn"><i class="fa-solid fa-boxes-stacked"></i>Inventario</a>
                <a href="admin_entregados.php" class="nav-btn active"><i class="fa-solid fa-check-double"></i>Entregados</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <div class="topbar-title">Entregados</div>
                    <div class="topbar-subtitle">Objetos devueltos a sus dueños</div>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="text" placeholder="Buscar entregado">
                    </div>
                    <div class="user-card">
                        <div class="user-avatar">A</div>
                        <div class="user-info">
                            <strong>Admin</strong>
                            <span>Super admin</span>
                        </div>
                    </div>
                </div>
            </div>

            <header class="content-header">
                <h2>Objetos Entregados</h2>
            </header>

            <?php if ($error): ?>
                <div class="alert alert-error">Error: <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <section class="table-panel">
                <?php if (empty($objetos)): ?>
                    <div class="empty-state">Todavia no hay objetos marcados como entregados.</div>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Objeto</th>
                                    <th>Categoria</th>
                                    <th>Ubicacion</th>
                                    <th>Estado</th>
                                    <th>Fecha encontrado</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($objetos as $objeto): ?>
                                    <tr>
                                        <td>
                                            <div class="object-cell">
                                                <img class="object-thumb" src="<?php echo htmlspecialchars(fotoAdmin($objeto['foto'])); ?>" alt="<?php echo htmlspecialchars($objeto['nombre']); ?>">
                                                <strong><?php echo htmlspecialchars($objeto['nombre']); ?></strong>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($objeto['categoria']); ?></td>
                                        <td><?php echo htmlspecialchars(trim($objeto['ubicacion'] . ' ' . $objeto['sector'])); ?></td>
                                        <td><span class="status-pill success"><?php echo htmlspecialchars($objeto['estado']); ?></span></td>
                                        <td><?php echo htmlspecialchars($objeto['fecha_encontrado']); ?></td>
                                        <td class="description-cell">
                                            <?php echo htmlspecialchars($objeto['descripcion']); ?><br>
                                            <span class="muted-text">
                                                <?php echo htmlspecialchars(trim(($objeto['marca'] ?: 'Sin marca') . ' - ' . ($objeto['color'] ?: 'Sin color'))); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

            <footer class="content-footer">
                <button type="button" class="btn-volver" onclick="window.location.href='admin_panel.php';">Volver</button>
            </footer>
        </main>
    </div>
</body>
</html>
