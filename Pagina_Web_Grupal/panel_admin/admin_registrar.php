<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Registrar Objeto</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin/panel-admin-estilo.css">
</head>
<body class="registro-page">
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
                <a href="admin_panel.php" class="nav-btn"><i class="fa-solid fa-house"></i>Dashboard</a>
                <a href="admin_inventario.php" class="nav-btn"><i class="fa-solid fa-boxes-stacked"></i>Inventario</a>
                <a href="admin_solicitudes.php" class="nav-btn"><i class="fa-solid fa-handshake-angle"></i>Solicitudes</a>
                <a href="admin_registrar.php" class="nav-btn active"><i class="fa-solid fa-clipboard-list"></i>Registros</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <button type="button" class="admin-menu-toggle" data-sidebar-toggle aria-label="Abrir menu" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="topbar-title">Formulario de Registros</div>
                    <div class="topbar-subtitle">Indexar un nuevo hallazgo al inventario</div>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="text" placeholder="Buscar registros por nombre">
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

            <?php if (isset($_GET['exito'])): ?>
                <div class="alert alert-success">El objeto se registro correctamente y su foto ya aparece en la pagina.</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <form action="../consultas_php/admin/procesar_registro.php" method="POST" enctype="multipart/form-data" class="form-grid-layout" id="formRegistroObjeto">
                <div class="form-card">
                    <h3><i class="fa-solid fa-pen-to-square"></i> Nuevo Objeto Encontrado</h3>
                    <p class="form-card-desc">Completa los campos para indexar el objeto al inventario oficial de la escuela.</p>

                    <div class="fields-grid">
                        <div class="input-group">
                            <label for="nombre">Nombre del objeto *</label>
                            <input type="text" id="nombre" name="nombre" required maxlength="100" placeholder="Ej. Mochila, campera, llaves...">
                        </div>

                        <div class="input-group">
                            <label for="categoria_texto">Categoria *</label>
                            <input type="text" id="categoria_texto" name="categoria_texto" required maxlength="50" placeholder="Ej. Utiles, vestimenta, tecnologia...">
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

                        <div class="input-group field-full">
                            <label for="descripcion">Descripcion *</label>
                            <textarea id="descripcion" name="descripcion" rows="4" required maxlength="800" placeholder="Detalles visibles del objeto..."></textarea>
                        </div>

                        <div class="input-group field-full">
                            <label for="observaciones">Observaciones <span class="optional-label">(opcional)</span></label>
                            <textarea id="observaciones" name="observaciones" rows="3" maxlength="800" placeholder="Notas adicionales del administrador..."></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-enviar"><i class="fa-solid fa-floppy-disk"></i> Guardar Objeto</button>
                    </div>
                </div>

                <div class="image-upload-section">
                    <h3><i class="fa-solid fa-image"></i> Foto del objeto *</h3>

                    <div class="image-preview-box" id="preview-box">
                        <span class="preview-placeholder"><i class="fa-solid fa-cloud-arrow-up"></i><br>Arrastra una imagen o haz clic para buscar<br><small>Formatos: JPG, PNG</small></span>
                    </div>

                    <div class="image-actions">
                        <label for="imagen_objeto" class="btn-agregar-imagen"><i class="fa-solid fa-upload"></i> Subir foto</label>
                        <input type="file" id="imagen_objeto" name="imagen_objeto" accept="image/*" class="file-input-hidden" required>
                        <button type="button" class="btn-limpiar-foto" id="btnLimpiarFoto"><i class="fa-solid fa-trash-can"></i> Quitar foto</button>
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

    <script src="../js/admin/panel-admin.js"></script>
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

        previewBox.addEventListener('click', () => {
            inputArchivo.click();
        });

        previewBox.addEventListener('dragenter', event => {
            event.preventDefault();
            event.stopPropagation();
            previewBox.classList.add('drag-over');
        });

        previewBox.addEventListener('dragover', event => {
            event.preventDefault();
            event.stopPropagation();
            previewBox.classList.add('drag-over');
        });

        previewBox.addEventListener('dragleave', event => {
            event.preventDefault();
            event.stopPropagation();
            previewBox.classList.remove('drag-over');
        });

        previewBox.addEventListener('drop', event => {
            event.preventDefault();
            event.stopPropagation();
            previewBox.classList.remove('drag-over');

            const file = event.dataTransfer.files[0];
            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                mensajeFoto.textContent = 'Solo puedes arrastrar una imagen.';
                return;
            }

            inputArchivo.files = event.dataTransfer.files;
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
