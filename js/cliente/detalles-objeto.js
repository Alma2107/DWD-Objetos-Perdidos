document.addEventListener("DOMContentLoaded", () => {
    const pantallaPrincipal = document.getElementById('pantalla-principal');
    const contenedorDetalle = document.getElementById('formularioObjetoContenedor');
    const btnInicioNav = document.getElementById('btnInicioNav');
    const btnLogoInicio = document.getElementById('btnLogoInicio');
    const btnReclamarNav = document.getElementById('btnReclamarNav');

    let objetoActual = null;

    document.addEventListener("click", (e) => {
        const tarjetaObjeto = e.target.closest('.carousel-item, .object-circle');

        if (tarjetaObjeto) {
            const idObjeto = tarjetaObjeto.getAttribute('data-id');
            if (idObjeto) {
                cargarVistaDetalle(idObjeto);
            }
        }
    });

    document.addEventListener("submit", (e) => {
        if (e.target.id === 'formSolicitudObjeto') {
            e.preventDefault();
            enviarSolicitud(e.target);
        }
    });

    [btnInicioNav, btnLogoInicio].forEach(btn => {
        btn.addEventListener('click', () => {
            document.body.className = "modo-inicio";
            contenedorDetalle.style.display = 'none';
            contenedorDetalle.innerHTML = '';
            pantallaPrincipal.style.display = 'block';
            btnReclamarNav.style.display = 'none';
            btnReclamarNav.removeAttribute('data-id-objeto');
            objetoActual = null;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    btnReclamarNav.addEventListener('click', () => {
        const panelSolicitud = document.getElementById('panelSolicitudObjeto');

        if (!panelSolicitud) {
            const idActual = btnReclamarNav.getAttribute('data-id-objeto');
            if (idActual) {
                cargarVistaDetalle(idActual, true);
            }
            return;
        }

        panelSolicitud.hidden = false;
        panelSolicitud.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    function cargarVistaDetalle(id, abrirSolicitud = false) {
        fetch(`consultas_php/usuario/obtener_objeto.php?id=${encodeURIComponent(id)}`)
            .then(response => {
                if (!response.ok) throw new Error("No se encontraron datos de este objeto.");
                return response.json();
            })
            .then(data => {
                if (data.error) throw new Error(data.mensaje || "No se pudo cargar el objeto.");
                objetoActual = data;
                renderizarFormularioObjeto(data, id, abrirSolicitud);
            })
            .catch(err => {
                console.error("Error al obtener objeto:", err);
                alert("No se pudo cargar el detalle del objeto.");
            });
    }

    function renderizarFormularioObjeto(objeto, id, abrirSolicitud = false) {
        document.body.className = "modo-detalle";
        pantallaPrincipal.style.display = 'none';
        contenedorDetalle.style.display = 'block';

        btnReclamarNav.setAttribute('data-id-objeto', id);
        btnReclamarNav.style.display = 'inline-block';

        const nombre = escaparHtml(objeto.nombre);
        const descripcion = escaparHtml(objeto.descripcion || 'Sin descripcion registrada.');
        const marca = objeto.marca ? escaparHtml(objeto.marca) : 'Sin marca';
        const color = objeto.color ? escaparHtml(objeto.color) : 'Sin color';
        const categoria = escaparHtml(objeto.categoria || 'Sin categoria');
        const ubicacion = escaparHtml(objeto.ubicacion || 'Sin ubicacion registrada');
        const estado = escaparHtml(objeto.estado || 'En custodia');
        const fecha = escaparHtml(objeto.fecha_encontrado || 'Sin fecha');
        const observaciones = objeto.observaciones ? escaparHtml(objeto.observaciones) : '';
        const foto = escaparAtributo(objeto.foto || 'img/default.png');

        contenedorDetalle.innerHTML = `
            <div class="detalle-cliente-wrap">
                <section class="modal-detalle-container">
                    <div class="detalle-left">
                        <div class="foto-circulo">
                            <img src="${foto}" alt="${nombre}">
                        </div>
                    </div>
                    <div class="detalle-right">
                        <span class="detalle-eyebrow">Detalle del objeto</span>
                        <h2>${nombre}</h2>
                        <div class="status-badge">${estado}</div>

                        <div class="info-row">
                            <div class="info-box">
                                <strong>Fecha encontrado</strong>
                                <span>${fecha}</span>
                            </div>
                            <div class="info-box">
                                <strong>Ubicacion</strong>
                                <span>${ubicacion}</span>
                            </div>
                        </div>

                        <div class="info-box-large">
                            <strong>Caracteristicas</strong>
                            <p>${descripcion}</p>
                            <div class="detalle-tags">
                                <span>Categoria: ${categoria}</span>
                                <span>Marca: ${marca}</span>
                                <span>Color: ${color}</span>
                            </div>
                            ${observaciones ? `<div class="extra-obs"><strong>Observaciones</strong>${observaciones}</div>` : ''}
                        </div>
                    </div>
                </section>

                <section class="solicitud-panel" id="panelSolicitudObjeto" ${abrirSolicitud ? '' : 'hidden'}>
                    <div class="solicitud-heading">
                        <span>Solicitud del objeto</span>
                        <h3>Reclamar ${nombre}</h3>
                        <p>Completa tus datos y explica una senal clara para demostrar que la pertenencia es tuya.</p>
                    </div>

                    <form id="formSolicitudObjeto" class="solicitud-form">
                        <input type="hidden" name="id_objeto" value="${escaparAtributo(String(id))}">

                        <div class="form-grid">
                            <label>
                                Nombre
                                <input type="text" name="nombre" maxlength="50" required>
                            </label>
                            <label>
                                Apellido
                                <input type="text" name="apellido" maxlength="50" required>
                            </label>
                            <label>
                                Curso
                                <input type="text" name="curso" maxlength="20" placeholder="Ej: 5to" required>
                            </label>
                            <label>
                                Division
                                <input type="text" name="division" maxlength="10" placeholder="Ej: A" required>
                            </label>
                            <label>
                                Email
                                <input type="email" name="email" maxlength="100" required>
                            </label>
                            <label>
                                Telefono
                                <input type="tel" name="telefono" maxlength="20" placeholder="Opcional">
                            </label>
                        </div>

                        <label class="form-full">
                            Por que sabes que es tuyo
                            <textarea name="descripcion_propiedad" rows="4" maxlength="600" placeholder="Ej: tiene una marca, stickers, contenido, detalle o senal particular." required></textarea>
                        </label>

                        <label class="form-full">
                            Observaciones
                            <textarea name="observaciones" rows="3" maxlength="400" placeholder="Opcional"></textarea>
                        </label>

                        <div class="form-actions">
                            <p id="mensajeSolicitud" class="mensaje-solicitud" aria-live="polite"></p>
                            <button type="submit" class="btn-enviar-solicitud">
                                <i class="fa-solid fa-paper-plane"></i>
                                Enviar solicitud
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        `;

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function enviarSolicitud(form) {
        const mensaje = document.getElementById('mensajeSolicitud');
        const boton = form.querySelector('button[type="submit"]');
        const datos = new FormData(form);

        mensaje.className = 'mensaje-solicitud';
        mensaje.textContent = 'Enviando solicitud...';
        boton.disabled = true;

        fetch('consultas_php/usuario/solicitudobjeto.php', {
            method: 'POST',
            body: datos
        })
            .then(response => response.json().then(data => ({ ok: response.ok, data })))
            .then(({ ok, data }) => {
                if (!ok || data.error) {
                    throw new Error(data.mensaje || 'No se pudo enviar la solicitud.');
                }

                mensaje.className = 'mensaje-solicitud exito';
                mensaje.textContent = `${data.mensaje} Numero de reclamo: #${data.id_solicitud}.`;
                form.reset();
            })
            .catch(err => {
                mensaje.className = 'mensaje-solicitud error';
                mensaje.textContent = err.message;
            })
            .finally(() => {
                boton.disabled = false;
            });
    }

    function escaparHtml(valor) {
        return String(valor ?? '').replace(/[&<>"']/g, caracter => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[caracter]));
    }

    function escaparAtributo(valor) {
        return escaparHtml(valor).replace(/`/g, '&#096;');
    }
});
