<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Registrar Objeto</title>
    <link rel="stylesheet" href="../css/admin/panel-admin-estilo.css">
    <style>
        .input-group select {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            background: rgba(12, 26, 64, 0.6);
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }
        .input-group select:focus {
            border-color: #72a3ff;
            background: rgba(12, 26, 64, 0.8);
        }
        .input-group select option { background: #0c1a40; color: #fff; }
        .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .alert-success { background: rgba(46, 204, 113, 0.2); color: #2ecc71; border: 1px solid #2ecc71; }
        .alert-error { background: rgba(231, 76, 60, 0.2); color: #e74c3c; border: 1px solid #e74c3c; }
        .optional-label { color: rgba(255, 255, 255, 0.4); font-size: 0.85rem; font-style: italic; }
    </style>
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
                <h2>Registrar - Objeto Completo</h2>
            </header>

            <?php if (isset($_GET['exito'])): ?>
                <div class="alert alert-success">¡El objeto se registró correctamente!</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <form action="../consultas_php/admin/procesar_registro.php" method="POST" enctype="multipart/form-data" class="form-grid-layout">
                
                <div class="form-card">
                    <h3>Datos del Objeto</h3>
                    
                    <div class="input-group">
                        <label for="nombre">Nombre del Objeto *</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Ej. Mochila, Campera, Llaves...">
                    </div>

                    <div class="input-group">
                        <label for="marca">Marca <span class="optional-label">(Opcional)</span></label>
                        <input type="text" id="marca" name="marca" placeholder="Ej. Adidas, Bic, Samsung...">
                    </div>

                    <div class="input-group">
                        <label for="color">Color <span class="optional-label">(Opcional)</span></label>
                        <input type="text" id="color" name="color" placeholder="Ej. Azul con líneas negras...">
                    </div>

                    <div class="input-group">
                        <label for="categoria_texto">Categoría *</label>
                        <input type="text" id="categoria_texto" name="categoria_texto" required placeholder="Ej. Útiles, Vestimenta, Electrónica...">
                    </div>

                    <div class="input-group">
                        <label for="ubicacion_texto">Ubicación donde se encontró *</label>
                        <input type="text" id="ubicacion_texto" name="ubicacion_texto" required placeholder="Ej. Patio central, Salón 6°3, Biblioteca...">
                    </div>

                    <div class="input-group">
                        <label for="estado_seleccionado">Estado actual del objeto *</label>
                        <select id="estado_seleccionado" name="estado_seleccionado" required>
                            <option value="Encontrado">Encontrado</option>
                            <option value="Devuelto">Devuelto</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="fecha_encontrado">Fecha en que se encontró *</label>
                        <input type="date" id="fecha_encontrado" name="fecha_encontrado" required value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="input-group">
                        <label for="descripcion">Descripción <span class="optional-label">(Opcional)</span></label>
                        <textarea id="descripcion" name="descripcion" rows="2" placeholder="Detalles específicos del objeto..."></textarea>
                    </div>

                    <div class="input-group">
                        <label for="observaciones">Observaciones <span class="optional-label">(Opcional)</span></label>
                        <textarea id="observaciones" name="observaciones" rows="2" placeholder="Notas adicionales del administrador..."></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-enviar">Guardar Objeto</button>
                    </div>
                </div>

                <div class="image-upload-section">
                    <div class="image-preview-box" id="preview-box">
                        <span class="preview-placeholder">Sin foto del objeto</span>
                    </div>
                    
                    <label for="imagen_objeto" class="btn-agregar-imagen">Cargar archivo de imagen</label>
                    <input type="file" id="imagen_objeto" name="imagen_objeto" accept="image/*" style="display: none;" onchange="previewImage(event)">
                </div>

            </form>

            <footer class="content-footer">
                <button type="button" class="btn-volver" onclick="window.history.back();">Volver</button>
            </footer>
        </main>
    </div>

    <script>
        function previewImage(event) {
            const previewBox = document.getElementById('preview-box');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewBox.innerHTML = `<img src="${e.target.result}" style="max-width: 100%; max-height: 100%; border-radius: 14px; object-fit: cover;">`;
                    previewBox.style.padding = '0';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html><?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Registrar Objeto</title>
    <link rel="stylesheet" href="../css/admin/panel-admin-estilo.css">
    <style>
        .input-group select {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            background: rgba(12, 26, 64, 0.6);
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }
        .input-group select:focus {
            border-color: #72a3ff;
            background: rgba(12, 26, 64, 0.8);
        }
        .input-group select option { background: #0c1a40; color: #fff; }
        .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .alert-success { background: rgba(46, 204, 113, 0.2); color: #2ecc71; border: 1px solid #2ecc71; }
        .alert-error { background: rgba(231, 76, 60, 0.2); color: #e74c3c; border: 1px solid #e74c3c; }
        .optional-label { color: rgba(255, 255, 255, 0.4); font-size: 0.85rem; font-style: italic; }
    </style>
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
                <h2>Registrar - Objeto Completo</h2>
            </header>

            <?php if (isset($_GET['exito'])): ?>
                <div class="alert alert-success">¡El objeto se registró correctamente!</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <form action="../consultas_php/admin/procesar_registro.php" method="POST" enctype="multipart/form-data" class="form-grid-layout">
                
                <div class="form-card">
                    <h3>Datos del Objeto</h3>
                    
                    <div class="input-group">
                        <label for="nombre">Nombre del Objeto *</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Ej. Mochila, Campera, Llaves...">
                    </div>

                    <div class="input-group">
                        <label for="marca">Marca <span class="optional-label">(Opcional)</span></label>
                        <input type="text" id="marca" name="marca" placeholder="Ej. Adidas, Bic, Samsung...">
                    </div>

                    <div class="input-group">
                        <label for="color">Color <span class="optional-label">(Opcional)</span></label>
                        <input type="text" id="color" name="color" placeholder="Ej. Azul con líneas negras...">
                    </div>

                    <div class="input-group">
                        <label for="categoria_texto">Categoría *</label>
                        <input type="text" id="categoria_texto" name="categoria_texto" required placeholder="Ej. Útiles, Vestimenta, Electrónica...">
                    </div>

                    <div class="input-group">
                        <label for="ubicacion_texto">Ubicación donde se encontró *</label>
                        <input type="text" id="ubicacion_texto" name="ubicacion_texto" required placeholder="Ej. Patio central, Salón 6°3, Biblioteca...">
                    </div>

                    <div class="input-group">
                        <label for="estado_seleccionado">Estado actual del objeto *</label>
                        <select id="estado_seleccionado" name="estado_seleccionado" required>
                            <option value="Encontrado">Encontrado</option>
                            <option value="Devuelto">Devuelto</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="fecha_encontrado">Fecha en que se encontró *</label>
                        <input type="date" id="fecha_encontrado" name="fecha_encontrado" required value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="input-group">
                        <label for="descripcion">Descripción <span class="optional-label">(Opcional)</span></label>
                        <textarea id="descripcion" name="descripcion" rows="2" placeholder="Detalles específicos del objeto..."></textarea>
                    </div>

                    <div class="input-group">
                        <label for="observaciones">Observaciones <span class="optional-label">(Opcional)</span></label>
                        <textarea id="observaciones" name="observaciones" rows="2" placeholder="Notas adicionales del administrador..."></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-enviar">Guardar Objeto</button>
                    </div>
                </div>

                <div class="image-upload-section">
                    <div class="image-preview-box" id="preview-box">
                        <span class="preview-placeholder">Sin foto del objeto</span>
                    </div>
                    
                    <label for="imagen_objeto" class="btn-agregar-imagen">Cargar archivo de imagen</label>
                    <input type="file" id="imagen_objeto" name="imagen_objeto" accept="image/*" style="display: none;" onchange="previewImage(event)">
                </div>

            </form>

            <footer class="content-footer">
                <button type="button" class="btn-volver" onclick="window.history.back();">Volver</button>
            </footer>
        </main>
    </div>

    <script>
        function previewImage(event) {
            const previewBox = document.getElementById('preview-box');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewBox.innerHTML = `<img src="${e.target.result}" style="max-width: 100%; max-height: 100%; border-radius: 14px; object-fit: cover;">`;
                    previewBox.style.padding = '0';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>