<?php
require_once __DIR__ . '/../conexion.php';

$solicitudes = [];
$error = null;

try {
    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();
    $sql = "SELECT
                s.id_solicitud,
                s.fecha_solicitud,
                s.descripcion_propiedad,
                s.observaciones,
                sol.nombre AS solicitante_nombre,
                sol.apellido AS solicitante_apellido,
                sol.telefono,
                o.id_objeto,
                o.nombre AS objeto_nombre,
                es.nombre AS estado_solicitud
            FROM solicitud s
            INNER JOIN solicitante sol ON s.id_solicitante = sol.id_solicitante
            INNER JOIN objeto o ON s.id_objeto = o.id_objeto
            INNER JOIN estado_solicitud es ON s.id_estado_solicitud = es.id_estado_solicitud
            WHERE LOWER(es.nombre) LIKE '%pendiente%'
            ORDER BY s.fecha_solicitud DESC, s.id_solicitud DESC";
    $solicitudes = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    // Depuración opcional: mostrar datos si se solicita con ?debug=1
    if (isset($_GET['debug']) && $_GET['debug'] == '1') {
        echo '<pre style="background:#fff;border:1px solid #ccc;padding:12px;">';
        echo "Solicitudes cargadas: " . count($solicitudes) . "\n\n";
        print_r(array_slice($solicitudes, 0, 5));
        echo '</pre>';
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Solicitudes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin/panel-admin-estilo.css">
    <?php if (isset($_GET['force_show']) && $_GET['force_show'] == '1'): ?>
    <style>
        .match-card { outline: 3px dashed rgba(255,0,0,0.9) !important; background: #fffbe6 !important; display: block !important; opacity: 1 !important; transform: none !important; }
        .request-card-grid { display: block !important; }
    </style>
    <?php endif; ?>
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
                <a href="admin_panel.php" class="nav-btn"><i class="fa-solid fa-house"></i>Dashboard</a>
                <a href="admin_inventario.php" class="nav-btn"><i class="fa-solid fa-boxes-stacked"></i>Inventario</a>
                <a href="admin_entregados.php" class="nav-btn"><i class="fa-solid fa-check-double"></i>Entregados</a>
                <a href="admin_solicitudes.php" class="nav-btn active"><i class="fa-solid fa-handshake-angle"></i>Solicitudes</a>
                <a href="admin_registrar.php" class="nav-btn"><i class="fa-solid fa-clipboard-list"></i>Registros</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <button type="button" class="admin-menu-toggle" data-sidebar-toggle aria-label="Abrir menu" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="topbar-title">Bandeja de Solicitudes</div>
                    <div class="topbar-subtitle">Aprobacion de devoluciones y validacion de identidad</div>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="text" id="request-search" placeholder="Buscar registros por solicitante u objeto">
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

            <section class="requests-intro">
                <h2><i class="fa-solid fa-handshake-angle"></i>Bandeja de Solicitudes de Devolucion</h2>
                <p>Revisa las pruebas e identificacion de los reclamantes para coordinar la entrega o archivar la solicitud.</p>
            </section>

            <?php if ($error): ?>
                <div class="alert alert-error">Error: <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if (empty($solicitudes)): ?>
                <div class="admin-page">
                    <div class="empty-state">Todavia no hay solicitudes cargadas.</div>
                </div>
            <?php else: ?>
                <section class="request-card-grid" id="request-grid">
                    <?php foreach ($solicitudes as $solicitud): ?>
                        <?php
                            $nombreCompleto = trim($solicitud['solicitante_nombre'] . ' ' . $solicitud['solicitante_apellido']);
                            $busqueda = strtolower($nombreCompleto . ' ' . $solicitud['objeto_nombre'] . ' ' . $solicitud['estado_solicitud']);
                        ?>
                            <article class="match-card" data-search="<?php echo htmlspecialchars($busqueda); ?>" data-id="<?php echo htmlspecialchars($solicitud['id_solicitud']); ?>">
                            <span class="status-badge reclamado match-badge">
                                <span class="status-dot"></span>
                                <?php echo htmlspecialchars($solicitud['estado_solicitud']); ?>
                            </span>

                            <div class="match-node">
                                <div class="match-node-icon"><i class="fa-solid fa-user"></i></div>
                                <div class="match-node-details">
                                    <h5><?php echo htmlspecialchars($nombreCompleto); ?> (Solicitante)</h5>
                                    <p>DNI/ID: Solicitud #<?php echo htmlspecialchars($solicitud['id_solicitud']); ?> | Tel: <?php echo htmlspecialchars($solicitud['telefono'] ?: 'Sin telefono'); ?></p>
                                </div>
                            </div>

                            <div class="match-node">
                                <div class="match-node-icon"><i class="fa-solid fa-box"></i></div>
                                <div class="match-node-details">
                                    <h5><?php echo htmlspecialchars($solicitud['objeto_nombre']); ?></h5>
                                    <p>ID Objeto: #<?php echo htmlspecialchars($solicitud['id_objeto']); ?></p>
                                </div>
                            </div>

                            <div class="match-proof-box">
                                <h6>Pruebas presentadas por el reclamante:</h6>
                                <p>"<?php echo htmlspecialchars($solicitud['descripcion_propiedad']); ?>"</p>
                            </div>

                            <div class="match-actions-row">
                                <button type="button" class="btn-confirm-delivery"><i class="fa-solid fa-check"></i> Aprobar y Entregar</button>
                                <button type="button" class="btn-reject-delivery" aria-label="Eliminar solicitud"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </main>
    </div>

    <script src="../js/admin/panel-admin.js"></script>
    <script>
        const requestSearch = document.getElementById('request-search');
        const requestCards = document.querySelectorAll('.match-card');

        requestSearch?.addEventListener('input', () => {
            const query = requestSearch.value.trim().toLowerCase();

            requestCards.forEach(card => {
                card.style.display = !query || card.dataset.search.includes(query) ? '' : 'none';
            });
        });
    </script>
    <?php if (isset($_GET['debug']) && $_GET['debug'] == '1'): ?>
    <script>
        // Debug DOM: cuenta .match-card y muestra un banner en la página (solo con ?debug=1)
        document.addEventListener('DOMContentLoaded', function(){
            try {
                const cards = document.querySelectorAll('.match-card');
                const banner = document.createElement('div');
                banner.style.position = 'fixed';
                banner.style.left = '12px';
                banner.style.bottom = '12px';
                banner.style.zIndex = 99999;
                banner.style.background = 'rgba(0,0,0,0.7)';
                banner.style.color = 'white';
                banner.style.padding = '8px 12px';
                banner.style.borderRadius = '8px';
                banner.style.fontWeight = '700';
                banner.textContent = 'DOM .match-card count: ' + cards.length;
                document.body.appendChild(banner);

                if (cards.length > 0) {
                    const info = document.createElement('pre');
                    info.style.position = 'fixed';
                    info.style.right = '12px';
                    info.style.bottom = '12px';
                    info.style.zIndex = 99999;
                    info.style.background = 'rgba(255,255,255,0.95)';
                    info.style.color = '#111';
                    info.style.padding = '8px 12px';
                    info.style.borderRadius = '8px';
                    info.style.maxHeight = '220px';
                    info.style.overflow = 'auto';
                    info.textContent = Array.from(cards).slice(0,5).map(c=>c.innerText.trim().slice(0,120)).join('\n---\n');
                    document.body.appendChild(info);
                }
            } catch(e) { console.error(e); }
        });
    </script>
    <?php endif; ?>
</body>
</html>
