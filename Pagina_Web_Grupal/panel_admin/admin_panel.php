<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Admin Panel</title>
    <link rel="stylesheet" href="../css/panel-admin-estilo.css">
</head>
<body>

    <div class="dashboard-container">
        
        <aside class="sidebar">
            <div class="brand">
                <h1>TECNOLOST</h1>
                <span>ADMIN PANEL</span>
            </div>
            
            <nav class="nav-menu">
                <a href="admin_panel.php" class="nav-btn active">Inicio</a>
                <a href="admin_registrar.php" class="nav-btn">Registrar</a>
                <a href="#" class="nav-btn">Solicitudes</a>
                <a href="#" class="nav-btn">Inventario</a>
                <a href="#" class="nav-btn">Entregados</a>
            </nav>
        </aside>

        <main class="main-content">
            
            <header class="content-header">
                <h2>Inicio - Resumen de objetos</h2>
            </header>

            <section class="cards-grid">
                
                <div class="card">
                    <h3>Total de solicitudes:</h3>
                    <div class="counter-box">X</div>
                </div>

                <div class="card">
                    <h3>Total de Inventario:</h3>
                    <div class="counter-box">X</div>
                </div>

            </section>

            <footer class="content-footer">
                <button class="btn-volver">Volver</button>
            </footer>

        </main>
    </div>

</body>
</html>