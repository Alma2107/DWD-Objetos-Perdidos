
document.addEventListener("DOMContentLoaded", () => {
    const selectCategoria = document.getElementById('selectCategoria');
    const inputBusqueda = document.getElementById('inputBusqueda');
    const gridPertenencias = document.getElementById('gridPertenencias');


    if (selectCategoria && inputBusqueda && gridPertenencias) {
        selectCategoria.addEventListener('change', ejecutarFiltro);
        inputBusqueda.addEventListener('input', ejecutarFiltro);
    }

    function ejecutarFiltro() {
        const idCategoria = selectCategoria.value;
        const textoBusqueda = inputBusqueda.value.trim();

        let url = `consultas_php/usuario/buscar.php?id_categoria=${idCategoria}&texto=${encodeURIComponent(textoBusqueda)}`;

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error("Error de respuesta de red.");
                return response.json();
            })
            .then(data => {
                let htmlResultado = "";

                if (data && data.length > 0) {
                    data.forEach(obj => {
                        const fotoRuta = obj.foto ? obj.foto : 'img/default.png';

                        htmlResultado += `
                            <div class="object-circle">
                                <img src="${fotoRuta}" alt="${obj.nombre}">
                                <p class="obj-grid-title" style="color: #ffffff;">${obj.nombre}</p>
                            </div>
                        `;
                    });
                } else {
                    htmlResultado = "<p class='error-search-message'>No se encontraron objetos con los criterios seleccionados.</p>";
                }

                gridPertenencias.innerHTML = htmlResultado;
            })
            .catch(err => {
                console.error("Error:", err);
                gridPertenencias.innerHTML = "<p class='error-fatal-message'>Error al procesar la búsqueda.</p>";
            });
    }

    
    const container = document.getElementById('carouselContainer');
    const track = document.getElementById('carouselTrack');

    if (track && container) {
        let posicionX = 0;
        let velocidad = 1; 

        container.addEventListener('mousemove', (e) => {
            const anchoContenedor = container.offsetWidth;
            const mouseX = e.clientX - container.getBoundingClientRect().left;

            if (mouseX < anchoContenedor / 2) {
                velocidad = -1.5; 
            } else {
                velocidad = 1.5;
            }
        });

        container.addEventListener('mouseleave', () => {
            velocidad = 1; 
        });

        function animarCarrusel() {
            posicionX += velocidad;
            const mitadAncho = track.scrollWidth / 2;

            if (posicionX >= 0 && velocidad > 0) {
                posicionX = -mitadAncho;
            } else if (posicionX <= -mitadAncho && velocidad < 0) {
                posicionX = 0;
            }

            track.style.transform = `translate3d(${posicionX}px, 0px, 0px)`;
            requestAnimationFrame(animarCarrusel);
        }

       
        if (track.children.length > 1) {
            requestAnimationFrame(animarCarrusel);
        }
    }
});