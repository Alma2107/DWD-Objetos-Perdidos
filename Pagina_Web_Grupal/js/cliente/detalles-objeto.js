// Archivo: js/detalles-objeto.js
document.addEventListener("DOMContentLoaded", () => {

    // Escuchamos los clics en TODO el sitio web
    document.addEventListener("click", (e) => {
        // .closest() busca hacia arriba en el HTML hasta encontrar el contenedor que tiene el data-id
        const tarjetaObjeto = e.target.closest('.carousel-item, .object-circle');
        
        if (tarjetaObjeto) {
            const idObjeto = tarjetaObjeto.getAttribute('data-id');
            if (idObjeto) {
                cargarVistaDetalle(idObjeto);
            }
        }
    });

    function cargarVistaDetalle(id) {
        // Llamamos al archivo PHP pasándole el ID del objeto
        fetch(`consultas_php/usuario/obtener_objeto.php?id=${id}`)
            .then(response => {
                if (!response.ok) throw new Error("No se encontraron datos de este objeto.");
                return response.json();
            })
            .then(data => {
                renderizarFormularioObjeto(data);
            })
            .catch(err => {
                console.error("Error al obtener objeto:", err);
                alert("No se pudo cargar el detalle del objeto. Revisa la consola.");
            });
    }

    function renderizarFormularioObjeto(objeto) {
        // Buscamos si ya existe el contenedor en la pantalla
        let contenedorDetalle = document.getElementById('formularioObjetoContenedor');
        
        if (!contenedorDetalle) {
            contenedorDetalle = document.createElement('div');
            contenedorDetalle.id = 'formularioObjetoContenedor';
            // Lo insertamos justo antes del footer de tu index.php
            const footer = document.querySelector('.main-footer');
            if (footer) {
                footer.parentNode.insertBefore(contenedorDetalle, footer);
            } else {
                document.body.appendChild(contenedorDetalle);
            }
        }

        // Estructura HTML con las clases exactas de tu archivo detalles.css
        contenedorDetalle.innerHTML = `
            <div class="modal-detalle-container">
                <div class="detalle-left">
                    <div class="foto-circulo">
                        <img src="${objeto.foto}" alt="${objeto.nombre}">
                    </div>
                </div>
                <div class="detalle-right">
                    <h2>${objeto.nombre}</h2>
                    <div class="status-badge">En custodia</div>
                    
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

        // Desplazamiento automático y suave hacia la tarjeta azul
        setTimeout(() => {
            contenedorDetalle.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }
});