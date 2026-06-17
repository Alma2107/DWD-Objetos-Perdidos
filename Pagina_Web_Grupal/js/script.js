// Archivo: js/script.js

let categoriaSeleccionada = "";

// ==========================================
// FILTROS Y BUSCADOR ASÍNCRONO (AJAX)
// ==========================================

// Escuchar clics en los botones de categorías
document.querySelectorAll('.btn-filtro-tag').forEach(boton => {
    boton.addEventListener('click', function() {
        document.querySelectorAll('.btn-filtro-tag').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        categoriaSeleccionada = this.getAttribute('data-id');
        ejecutarBusquedaCombinada();
    });
});

// Escuchar tipeo en tiempo real en la barra de búsqueda
const buscadorInput = document.getElementById('inputBuscadorTexto');
if (buscadorInput) {
    buscadorInput.addEventListener('input', function() {
        ejecutarBusquedaCombinada();
    });
}

// Función unificada AJAX para actualizar la grilla
function ejecutarBusquedaCombinada() {
    const textoBusqueda = document.getElementById('inputBuscadorTexto').value;
    const gridPertenencias = document.getElementById('gridPertenencias');

    fetch(`consultas_php/usuario/buscar.php?id_categoria=${categoriaSeleccionada}&texto=${encodeURIComponent(textoBusqueda)}`)
        .then(response => {
            if (!response.ok) throw new Error("Error en la respuesta del servidor.");
            return response.json();
        })
        .then(data => {
            let htmlResultado = "";

            if (data && data.length > 0) {
                data.forEach(obj => {
                    const nombreSanitizado = (obj.nombre || '').replace(/'/g, "\\'");
                    const descSanitizada = (obj.descripcion || '').replace(/'/g, "\\'");
                    const colorSanitizado = (obj.color || '').replace(/'/g, "\\'");
                    const marcaSanitizado = (obj.marca || '').replace(/'/g, "\\'");
                    const fotoRuta = obj.foto ? obj.foto : 'img/default.png';

                    htmlResultado += `
                        <div class="object-circle" onclick="abrirModalDetalle('${nombreSanitizado}', '${descSanitizada}', '${colorSanitizado}', '${marcaSanitizado}', '${obj.fecha_encontrado}', '${fotoRuta}')">
                            <img src="${fotoRuta}" alt="${obj.nombre}">
                            <p class="obj-grid-title">${obj.nombre}</p>
                        </div>
                    `;
                });
            } else {
                htmlResultado = "<p class='no-results-alert'>No se encontraron objetos coincidentes para esta búsqueda.</p>";
            }

            gridPertenencias.innerHTML = htmlResultado;
        })
        .catch(err => {
            console.error("Error en AJAX:", err);
            gridPertenencias.innerHTML = "<p style='color: red; text-align: center; width:100%;'>Error al procesar la búsqueda.</p>";
        });
}

// ==========================================
// MOTOR INTELIGENTE DEL CARRUSEL (MOVIMIENTO POR BORDES)
// ==========================================
const track = document.getElementById('trackCarrusel');
const contenedor = document.querySelector('.carrusel-contenedor');

if (track && contenedor) {
    let intervalId = null;
    const velocidadDeScroll = 6; // Píxeles de avance por ciclo

    contenedor.addEventListener('mousemove', (e) => {
        const rect = contenedor.getBoundingClientRect();
        const xRelativa = e.clientX - rect.left; // Posición horizontal exacta del cursor dentro de la caja azul
        const anchoTotal = rect.width;

        // Zona Activa Derecha (último 20% del recuadro) -> Avanza hacia adelante
        if (xRelativa > anchoTotal * 0.80) {
            if (!intervalId) {
                intervalId = setInterval(() => {
                    track.scrollLeft += velocidadDeScroll;
                }, 10);
            }
        } 
        // Zona Activa Izquierda (primer 20% del recuadro) -> Retrocede hacia atrás
        else if (xRelativa < anchoTotal * 0.20) {
            if (!intervalId) {
                intervalId = setInterval(() => {
                    track.scrollLeft -= velocidadDeScroll;
                }, 10);
            }
        } 
        // Zona Neutra Central -> Se detiene inmediatamente
        else {
            clearInterval(intervalId);
            intervalId = null;
        }
    });

    // Detener movimiento por completo si el cursor sale del cuadro azul
    contenedor.addEventListener('mouseleave', () => {
        clearInterval(intervalId);
        intervalId = null;
    });
}

// ==========================================
// CONTROL DE MODALES (DETALLES DE OBJETOS)
// ==========================================
function abrirModalDetalle(nombre, descripcion, color, marca, fecha, foto) {
    document.getElementById('modalNombre').innerText = nombre;
    document.getElementById('modalFoto').src = foto;
    document.getElementById('modalDescripcion').innerText = descripcion ? descripcion : 'Sin especificaciones registradas.';
    document.getElementById('modalColor').innerText = color ? color : 'No especifica';
    document.getElementById('modalMarca').innerText = marca ? marca : 'Genérica / Desconocida';
    document.getElementById('modalFecha').innerText = fecha ? fecha : 'No registrada';
    document.getElementById('modalDetalleObjeto').style.display = 'block';
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalleObjeto').style.display = 'none';
}

window.onclick = function(e) {
    const modal = document.getElementById('modalDetalleObjeto');
    if (e.target === modal) modal.style.display = 'none';
}