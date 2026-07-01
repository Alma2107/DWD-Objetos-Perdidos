<?php
require_once '../consultas_php/admin/verificar_sesion.php';
require_once __DIR__ . '/../conexion.php';

$totalSolicitudes = 0;
$totalInventario = 0;
$totalEntregados = 0;
$ultimosObjetos = [];
$solicitudesRecientes = [];
$error = null;

try {
    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();

    $totalSolicitudes = (int)$db->query("SELECT COUNT(*)
        FROM solicitud s
        INNER JOIN estado_solicitud es ON s.id_estado_solicitud = es.id_estado_solicitud
        WHERE LOWER(es.nombre) LIKE '%pendiente%'")->fetchColumn();
    $totalInventario = (int)$db->query("SELECT COUNT(*) FROM objeto o INNER JOIN estado_objeto eo ON o.id_estado_objeto = eo.id_estado_objeto WHERE NOT (LOWER(eo.nombre) LIKE '%devuelto%' OR LOWER(eo.nombre) LIKE '%entregado%' OR LOWER(eo.nombre) LIKE '%reclam%')")->fetchColumn();
    $totalEntregados = (int)$db->query("SELECT COUNT(*)
        FROM objeto o
        INNER JOIN estado_objeto eo ON o.id_estado_objeto = eo.id_estado_objeto
        WHERE LOWER(eo.nombre) LIKE '%devuelto%' OR LOWER(eo.nombre) LIKE '%entregado%'")->fetchColumn();

    $ultimosObjetos = $db->query("SELECT
            o.nombre,
            c.nombre AS categoria,
            eo.nombre AS estado
        FROM objeto o
        INNER JOIN categoria c ON o.id_categoria = c.id_categoria
        INNER JOIN estado_objeto eo ON o.id_estado_objeto = eo.id_estado_objeto
        WHERE NOT (LOWER(eo.nombre) LIKE '%devuelto%' OR LOWER(eo.nombre) LIKE '%entregado%' OR LOWER(eo.nombre) LIKE '%reclam%')
        ORDER BY o.fecha_registro DESC, o.id_objeto DESC
        LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);

    $solicitudesRecientes = $db->query("SELECT
            sol.nombre AS solicitante_nombre,
            sol.apellido AS solicitante_apellido,
            o.nombre AS objeto_nombre
        FROM solicitud s
        INNER JOIN solicitante sol ON s.id_solicitante = sol.id_solicitante
        INNER JOIN objeto o ON s.id_objeto = o.id_objeto
        ORDER BY s.fecha_solicitud DESC, s.id_solicitud DESC
        LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = $e->getMessage();
}

function inicialesAdmin($nombre) {
    $partes = preg_split('/\s+/', trim($nombre));
    $iniciales = '';

    foreach ($partes as $parte) {
        if ($parte !== '') {
            $iniciales .= strtoupper(substr($parte, 0, 1));
        }
        if (strlen($iniciales) >= 2) {
            break;
        }
    }

    return $iniciales ?: 'AD';
}

function estadoClaseAdmin($estado) {
    $estadoLower = strtolower($estado);

    if (strpos($estadoLower, 'devuelto') !== false || strpos($estadoLower, 'entregado') !== false) {
        return 'entregado';
    }

    if (strpos($estadoLower, 'reclam') !== false || strpos($estadoLower, 'solicit') !== false) {
        return 'reclamado';
    }

    return 'en-almacen';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin/panel-admin-estilo.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar-backdrop" data-sidebar-backdrop></div>

        <aside class="sidebar">
            <div class="brand">
                <div>
                    <h1>TECNOLOST</h1>
                    <span>ADMIN PANEL</span>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="../index.php" class="nav-btn"><i class="fa-solid fa-arrow-left"></i>Volver a la web</a>
                <a href="admin_panel.php" class="nav-btn active"><i class="fa-solid fa-house"></i>Dashboard</a>
                <a href="admin_inventario.php" class="nav-btn"><i class="fa-solid fa-boxes-stacked"></i>Inventario</a>
                <a href="admin_entregados.php" class="nav-btn"><i class="fa-solid fa-check-double"></i>Entregados</a>
                <a href="admin_solicitudes.php" class="nav-btn"><i class="fa-solid fa-handshake-angle"></i>Solicitudes</a>
                <a href="admin_registrar.php" class="nav-btn"><i class="fa-solid fa-clipboard-list"></i>Registros</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <button type="button" class="admin-menu-toggle" data-sidebar-toggle aria-label="Abrir menu" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="topbar-title">Dashboard</div>
                    <div class="topbar-subtitle">Resumen general y control de existencias</div>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="text" placeholder="Buscar registros por nombre, categoria o estado">
                    </div>
                    <div class="user-card">
                        <div class="user-info">
                            <strong>Administrador</strong>
                            <span>Super Admin</span>
                        </div>
                        <div class="user-avatar">AD</div>
                    </div>
                </div>
            </div>

            <section class="cards-grid admin-page">
                <div class="stat-card highlight">
                    <div class="stat-info">
                        <h3><?php echo $totalSolicitudes; ?></h3>
                        <p>Total de solicitudes</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-inbox"></i></div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3><?php echo $totalInventario; ?></h3>
                        <p>Disponibles</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3><?php echo $totalEntregados; ?></h3>
                        <p>Entregados</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-check-double"></i></div>
                </div>
            </section>

            <div class="admin-page">
                <?php if ($error): ?>
                    <div class="alert alert-error">Error: <?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <section class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title"><i class="fa-solid fa-clock-rotate-left"></i>Ultimos objetos disponibles</h2>
                        <a class="panel-link" href="admin_inventario.php">Ver inventario disponible <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    <?php if (empty($ultimosObjetos)): ?>
                        <div class="empty-state">Todavia no hay objetos registrados.</div>
                    <?php else: ?>
                        <table class="recent-table">
                            <thead>
                                <tr>
                                    <th>Descripcion del objeto</th>
                                    <th>Categoria</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ultimosObjetos as $objeto): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($objeto['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($objeto['categoria']); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo estadoClaseAdmin($objeto['estado']); ?>">
                                                <span class="status-dot"></span>
                                                <?php echo htmlspecialchars($objeto['estado']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </section>

                <section class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title"><i class="fa-solid fa-user-clock"></i>Solicitudes Recientes</h2>
                        <a class="panel-link" href="admin_solicitudes.php">Ver Solicitudes <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    <?php if (empty($solicitudesRecientes)): ?>
                        <div class="empty-state">Todavia no hay solicitudes recientes.</div>
                    <?php else: ?>
                        <div class="request-summary-list">
                            <?php foreach ($solicitudesRecientes as $solicitud): ?>
                                <?php
                                    $nombreCompleto = trim($solicitud['solicitante_nombre'] . ' ' . $solicitud['solicitante_apellido']);
                                ?>
                                <article class="request-summary-card">
                                    <div class="summary-avatar"><?php echo htmlspecialchars(inicialesAdmin($nombreCompleto)); ?></div>
                                    <div>
                                        <h4><?php echo htmlspecialchars($nombreCompleto); ?></h4>
                                        <p>Reclama: <?php echo htmlspecialchars($solicitud['objeto_nombre']); ?></p>
                                    </div>
                                    <a class="view-button" href="admin_solicitudes.php" aria-label="Ver solicitud">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </main>
    </div>

    <script src="../js/admin/panel-admin.js"></script>
</body>
</html>
