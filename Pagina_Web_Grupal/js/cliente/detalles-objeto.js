// Archivo: js/cliente/detalles-objeto.js
document.addEventListener("DOMContentLoaded", () => {

    const pantallaPrincipal = document.getElementById('pantalla-principal');
    const contenedorDetalle = document.getElementById('formularioObjetoContenedor');
    const btnInicioNav = document.getElementById('btnInicioNav');
    const btnLogoInicio = document.getElementById('btnLogoInicio');
    const btnReclamarNav = document.getElementById('btnReclamarNav');

    // Escuchamos los clics en las tarjetas del carrusel o de la cuadrícula
    document.addEventListener("click", (e) => {
        const tarjetaObjeto = e.target.closest('.carousel-item, .object-circle');
        
        if (tarjetaObjeto) {
            const idObjeto = tarjetaObjeto.getAttribute('data-id');
            if (idObjeto) {
                cargarVistaDetalle(idObjeto);
            }
        }
    });

    // Acción para volver al inicio al pulsar "Inicio" o el Logo
    [btnInicioNav, btnLogoInicio].forEach(btn => {
        btn.addEventListener('click', () => {
            document.body.className = "modo-inicio";
            contenedorDetalle.style.display = 'none';
            pantallaPrincipal.style.display = 'block';
            btnReclamarNav.style.display = 'none';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // Acción para el botón reclamar objeto
    btnReclamarNav.addEventListener('click', () => {
        const idActual = btnReclamarNav.getAttribute('data-id-objeto');
        alert(`Iniciando reclamo para el objeto ID: ${idActual}. Dirígete a la administración.`);
    });

    function cargarVistaDetalle(id) {
        fetch(`consultas_php/usuario/obtener_objeto.php?id=${id}`)
            .then(response => {
                if (!response.ok) throw new Error("No se encontraron datos de este objeto.");
                return response.json();
            })
            .then(data => {
                renderizarFormularioObjeto(data, id);
            })
            .catch(err => {
                console.error("Error al obtener objeto:", err);
                alert("No se pudo cargar el detalle del objeto.");
            });
    }

    function renderizarFormularioObjeto(objeto, id) {
        // Cambiamos el modo de pantalla en el body
        document.body.className = "modo-detalle";
        
        // Ocultamos el inicio y mostramos el contenedor de detalles arriba
        pantallaPrincipal.style.display = 'none';
        contenedorDetalle.style.display = 'block';
        
        // Configuramos y mostramos el botón de reclamo en la barra superior
        btnReclamarNav.setAttribute('data-id-objeto', id);
        btnReclamarNav.style.display = 'inline-block';

        // Construimos el HTML limpio usando tu estructura exacta
        contenedorDetalle.innerHTML = `
            <div class="modal-detalle-container">
                <div class="detalle-left">
                    <div class="foto-circulo">
                        <img src="${objeto.foto ? objeto.foto : 'img/default.png'}" alt="${objeto.nombre}">
                    </div>
                </div>
                <div class="detalle-right">
                    <h2>${objeto.nombre}</h2>
                    <div class="status-badge">Estado: En custodia</div>
                    
                    <div class="info-row">
                        <div class="info-box">
                            <strong>Fecha:</strong> ${objeto.fecha_encontrado}
                        </div>
                        <div class="info-box">
                            <strong>Ubicación:</strong> Interna / Biblioteca
                        </div>
                    </div>
                    
                    <div class="info-box-large">
                        <strong>Características:</strong>
                        <p>${objeto.descripcion}</p>
                        ${objeto.marca ? `<p><strong>Marca:</strong> ${objeto.marca}</p>` : ''}
                        ${objeto.color ? `<p><strong>Color:</strong> ${objeto.color}</p>` : ''}
                        ${objeto.observaciones ? `<div class="extra-obs"><strong>Observaciones:</strong> ${objeto.observaciones}</div>` : ''}
                    </div>
                </div>
            </div>
        `;
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});