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
                <h2>Registrar Objeto Perdido</h2>
            </header>

            <?php if (isset($_GET['exito'])): ?>
                <div class="alert alert-success">El objeto se registro correctamente y su foto ya aparece en la pagina.</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <form action="../consultas_php/admin/procesar_registro.php" method="POST" enctype="multipart/form-data" class="form-grid-layout" id="formRegistroObjeto">
                <div class="form-card">
                    <h3>Datos del Objeto</h3>

                    <div class="input-group">
                        <label for="nombre">Nombre del objeto *</label>
                        <input type="text" id="nombre" name="nombre" required maxlength="100" placeholder="Ej. Mochila, campera, llaves...">
                    </div>

                    <div class="input-group">
                        <label for="marca">Marca <span class="optional-label">(opcional)</span></label>
                        <input type="text" id="marca" name="marca" maxlength="50" placeholder="Ej. Adidas, Bic, Samsung...">
                    </div>

                    <div class="input-group">
                        <label for="color">Color <span class="optional-label">(opcional)</span></label>
                        <input type="text" id="color" name="color" maxlength="50" placeholder="Ej. Azul con lineas negras...">
                    </div>

                    <div class="input-group">
                        <label for="categoria_texto">Categoria *</label>
                        <input type="text" id="categoria_texto" name="categoria_texto" required maxlength="50" placeholder="Ej. Utiles, vestimenta, tecnologia...">
                    </div>

                    <div class="input-group">
                        <label for="ubicacion_texto">Ubicacion donde se encontro *</label>
                        <input type="text" id="ubicacion_texto" name="ubicacion_texto" required maxlength="50" placeholder="Ej. Patio central, Salon 6to 3ra, Biblioteca...">
                    </div>

                    <div class="input-group">
                        <label for="estado_seleccionado">Estado actual del objeto *</label>
                        <select id="estado_seleccionado" name="estado_seleccionado" required>
                            <option value="Encontrado">Encontrado</option>
                            <option value="En Resguardo">En Resguardo</option>
                            <option value="Devuelto">Devuelto</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="fecha_encontrado">Fecha en que se encontro *</label>
                        <input type="date" id="fecha_encontrado" name="fecha_encontrado" required value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="input-group">
                        <label for="descripcion">Descripcion *</label>
                        <textarea id="descripcion" name="descripcion" rows="3" required maxlength="800" placeholder="Detalles visibles del objeto..."></textarea>
                    </div>

                    <div class="input-group">
                        <label for="observaciones">Observaciones <span class="optional-label">(opcional)</span></label>
                        <textarea id="observaciones" name="observaciones" rows="2" maxlength="800" placeholder="Notas adicionales del administrador..."></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-enviar">Guardar Objeto</button>
                    </div>
                </div>

                <div class="image-upload-section">
                    <h3>Foto del objeto *</h3>

                    <div class="image-preview-box" id="preview-box">
                        <span class="preview-placeholder">Elegir archivo de imagen</span>
                    </div>

                    <div class="image-actions">
                        <label for="imagen_objeto" class="btn-agregar-imagen">Subir foto</label>
                        <input type="file" id="imagen_objeto" name="imagen_objeto" accept="image/*" class="file-input-hidden" required>
                        <button type="button" class="btn-limpiar-foto" id="btnLimpiarFoto">Quitar foto</button>
                    </div>

                    <p class="foto-help">Saca la foto con el celular, pasala a esta computadora y subila aca como archivo. Se guarda en <strong>uploads</strong> y aparece automaticamente en la pagina.</p>
                    <p class="mensaje-foto" id="mensajeFoto" aria-live="polite"></p>
                </div>
            </form>

            <footer class="content-footer">
                <button type="button" class="btn-volver" onclick="window.history.back();">Volver</button>
            </footer>
        </main>
    </div>

    <script>
        const inputArchivo = document.getElementById('imagen_objeto');
        const previewBox = document.getElementById('preview-box');
        const btnLimpiarFoto = document.getElementById('btnLimpiarFoto');
        const mensajeFoto = document.getElementById('mensajeFoto');
        const formRegistro = document.getElementById('formRegistroObjeto');

        inputArchivo.addEventListener('change', () => {
            const file = inputArchivo.files[0];

            if (!file) {
                limpiarPreview();
                return;
            }

            if (!file.type.startsWith('image/')) {
                mensajeFoto.textContent = 'Selecciona un archivo de imagen valido.';
                inputArchivo.value = '';
                limpiarPreview();
                return;
            }

            const reader = new FileReader();
            reader.onload = event => mostrarPreview(event.target.result);
            reader.readAsDataURL(file);
            mensajeFoto.textContent = '';
        });

        btnLimpiarFoto.addEventListener('click', () => {
            inputArchivo.value = '';
            limpiarPreview();
            mensajeFoto.textContent = '';
        });

        formRegistro.addEventListener('submit', event => {
            if (!inputArchivo.files.length) {
                event.preventDefault();
                mensajeFoto.textContent = 'Antes de guardar, subi la foto del objeto como archivo.';
                inputArchivo.focus();
            }
        });

        function mostrarPreview(src) {
            previewBox.hidden = false;
            previewBox.innerHTML = `<img src="${src}" alt="Vista previa del objeto">`;
        }

        function limpiarPreview() {
            previewBox.hidden = false;
            previewBox.innerHTML = '<span class="preview-placeholder">Elegir archivo de imagen</span>';
        }
    </script>
</body>
</html>
