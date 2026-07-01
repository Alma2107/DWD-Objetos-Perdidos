<?php
require_once __DIR__ . '/../conexion.php';

$objetos = [];
$categorias = [];
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
                c.nombre AS categoria,
                u.nombre AS ubicacion,
                u.sector,
                eo.nombre AS estado
            FROM objeto o
            INNER JOIN categoria c ON o.id_categoria = c.id_categoria
            INNER JOIN ubicacion u ON o.id_ubicacion = u.id_ubicacion
            INNER JOIN estado_objeto eo ON o.id_estado_objeto = eo.id_estado_objeto
            WHERE NOT (LOWER(eo.nombre) LIKE '%devuelto%' OR LOWER(eo.nombre) LIKE '%entregado%' OR LOWER(eo.nombre) LIKE '%reclam%')
            ORDER BY o.fecha_registro DESC, o.id_objeto DESC";
    $objetos = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $categorias = $db->query('SELECT nombre FROM categoria ORDER BY nombre')->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    $error = $e->getMessage();
}

function inicialesObjetoAdmin($nombre) {
    $palabras = preg_split('/\s+/', trim($nombre));
    $iniciales = '';

    foreach ($palabras as $palabra) {
        if ($palabra !== '') {
            $iniciales .= strtoupper(substr($palabra, 0, 1));
        }
        if (strlen($iniciales) >= 2) {
            break;
        }
    }

    return $iniciales ?: 'OB';
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

function textoAccionObjeto($estado) {
    $estadoLower = strtolower($estado);

    if (strpos($estadoLower, 'devuelto') !== false || strpos($estadoLower, 'entregado') !== false) {
        return 'Entregado';
    }

    if (strpos($estadoLower, 'reclam') !== false || strpos($estadoLower, 'solicit') !== false) {
        return 'Ya solicitado';
    }

    return 'Disponible';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Inventario</title>
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
                <a href="admin_panel.php" class="nav-btn"><i class="fa-solid fa-house"></i>Dashboard</a>
                <a href="admin_inventario.php" class="nav-btn active"><i class="fa-solid fa-boxes-stacked"></i>Inventario</a>
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
                    <div class="topbar-title">Inventario de Almacen</div>
                    <div class="topbar-subtitle">Busca tu objeto perdido y solicita su vuelta</div>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="text" id="inventory-search" placeholder="Buscar registros por nombre">
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

            <?php if ($error): ?>
                <div class="alert alert-error">Error: <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="filter-tabs" id="category-filters">
                <button type="button" class="filter-btn active" data-filter="todos">Todos</button>
                <?php foreach ($categorias as $categoria): ?>
                    <button type="button" class="filter-btn" data-filter="<?php echo htmlspecialchars(strtolower($categoria)); ?>">
                        <?php echo htmlspecialchars($categoria); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <?php if (empty($objetos)): ?>
                <div class="admin-page">
                    <div class="empty-state">Todavia no hay objetos registrados.</div>
                </div>
            <?php else: ?>
                <section class="inventory-grid" id="inventory-grid">
                    <?php foreach ($objetos as $objeto): ?>
                        <?php
                            $estadoClase = estadoClaseAdmin($objeto['estado']);
                            $fecha = $objeto['fecha_encontrado'] ? date('d/m/Y', strtotime($objeto['fecha_encontrado'])) : '';
                        ?>
                        <article class="inventory-card" data-category="<?php echo htmlspecialchars(strtolower($objeto['categoria'])); ?>" data-search="<?php echo htmlspecialchars(strtolower($objeto['nombre'] . ' ' . $objeto['categoria'] . ' ' . $objeto['estado'])); ?>">
                            <div class="inventory-card-header">
                                <span class="category-tag"><?php echo htmlspecialchars($objeto['categoria']); ?></span>
                                <div class="inventory-initials"><?php echo htmlspecialchars(inicialesObjetoAdmin($objeto['nombre'])); ?></div>
                            </div>

                            <div>
                                <h3 class="inventory-title"><?php echo htmlspecialchars($objeto['nombre']); ?></h3>
                                <p class="inventory-meta"><i class="fa-solid fa-map-pin"></i> Hallado en: <?php echo htmlspecialchars(trim($objeto['ubicacion'] . ' ' . $objeto['sector'])); ?></p>
                                <p class="inventory-meta"><i class="fa-solid fa-circle-info"></i> <?php echo htmlspecialchars($objeto['descripcion']); ?></p>
                            </div>

                            <div>
                                <button type="button" class="disabled-action" disabled>
                                    <i class="fa-solid fa-handshake-angle"></i> <?php echo htmlspecialchars(textoAccionObjeto($objeto['estado'])); ?>
                                </button>
                            </div>

                            <div class="inventory-card-footer">
                                <span class="status-badge <?php echo $estadoClase; ?>">
                                    <span class="status-dot"></span>
                                    <?php echo htmlspecialchars($objeto['estado']); ?>
                                </span>
                                <span class="muted-text"><?php echo htmlspecialchars($fecha); ?></span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </main>
    </div>

    <script src="../js/admin/panel-admin.js"></script>
    <script>
        const filterButtons = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.inventory-card');
        const searchInput = document.getElementById('inventory-search');
        let activeFilter = 'todos';

        function applyInventoryFilters() {
            const query = (searchInput?.value || '').trim().toLowerCase();

            cards.forEach(card => {
                const matchesFilter = activeFilter === 'todos' || card.dataset.category === activeFilter;
                const matchesSearch = !query || card.dataset.search.includes(query);
                card.style.display = matchesFilter && matchesSearch ? '' : 'none';
            });
        }

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(item => item.classList.remove('active'));
                button.classList.add('active');
                activeFilter = button.dataset.filter;
                applyInventoryFilters();
            });
        });

        searchInput?.addEventListener('input', applyInventoryFilters);
    </script>
</body>
</html>
