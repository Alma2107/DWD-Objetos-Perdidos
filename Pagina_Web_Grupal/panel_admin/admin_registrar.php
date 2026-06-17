<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Registrar Objeto</title>
    <link rel="stylesheet" href="../css/admin/panel-admin-estilo.css">
</head>
<body>

    <div class="dashboard-container">
        
        <aside class="sidebar">
            <div class="brand">
                <h1>TECNOLOST</h1>
                <span>ADMIN PANEL</span>
            </div>
            
            <nav class="nav-menu">
                <a href="admin_panel.php" class="nav-btn">Inicio</a>
                <a href="admin_registrar.php" class="nav-btn active">Registrar</a>
                <a href="#" class="nav-btn">Solicitudes</a>
                <a href="#" class="nav-btn">Inventario</a>
                <a href="#" class="nav-btn">Entregados</a>
            </nav>
        </aside>

        <main class="main-content">
            
            <header class="content-header">
                <h2>Registrar - Objetos nuevos</h2>
            </header>

            <form action="procesar_registro.php" method="POST" enctype="multipart/form-data" class="form-grid-layout">
                
                <div class="form-card">
                    <h3>Registrar un nuevo objeto</h3>
                    
                    <div class="input-group">
                        <label for="objeto">Objeto:</label>
                        <input type="text" id="objeto" name="objeto" required placeholder="Ej. Computadora Intel i7">
                    </div>

                    <div class="input-group">
                        <label for="tipo_objeto">Tipo de objeto:</label>
                        <input type="text" id="tipo_objeto" name="tipo_objeto" required placeholder="Ej. Hardware / Periférico">
                    </div>

                    <div class="input-group">
                        <label for="horario_encontrado">Horario encontrado:</label>
                        <input type="time" id="horario_encontrado" name="horario_encontrado" required>
                    </div>

                    <div class="input-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="3" placeholder="Detalles del estado del objeto..."></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-enviar">Enviar</button>
                    </div>
                </div>

                <div class="image-upload-section">
                    <div class="image-preview-box">
                        <span class="preview-placeholder">Sin imagen</span>
                    </div>
                    
                    <label for="imagen_objeto" class="btn-agregar-imagen">Agregar imagen</label>
                    <input type="file" id="imagen_objeto" name="imagen_objeto" accept="image/*" style="display: none;">
                </div>

            </form>

            <footer class="content-footer">
                <button type="button" class="btn-volver" onclick="window.history.back();">Volver</button>
            </footer>

        </main>
    </div>

</body>
</html>