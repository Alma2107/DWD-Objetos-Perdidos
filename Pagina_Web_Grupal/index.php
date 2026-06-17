<?php
// Archivo: C:\xampp\htdocs\DWD-Objetos-Perdidos\Pagina_Web_Grupal\index.php

require_once __DIR__ . '/conexion.php';                 
require_once __DIR__ . '/clases/php/objeto.php';       
require_once __DIR__ . '/clases/daos/objetoDao.php';   
require_once __DIR__ . '/clases/php/cateogoria.php';      
require_once __DIR__ . '/clases/daos/cateogoriaDao.php';  

try {
    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();

    $daoObjeto = new ObjetoDAO($db);
    
    // 1. Carga para el carrusel superior: Solo objetos perdidos HOY
    $fechaHoy = date('Y-m-d');
    $objetosDeHoy = [];
    
    // Obtenemos todos los objetos para filtrar o puedes crear un método en tu DAO si prefieres: $daoObjeto->listarPorFecha($fechaHoy);
    $todosLosObjetos = $daoObjeto->listarTodos(); 
    if (!empty($todosLosObjetos)) {
        foreach ($todosLosObjetos as $obj) {
            // Evaluamos si coincide con la fecha actual (asumiendo que getFechaEncontrado() devuelve 'YYYY-MM-DD' o similar)
            if (substr($obj->getFechaEncontrado(), 0, 10) === $fechaHoy) {
                $objetosDeHoy[] = $obj;
            }
        }
    }

    // 2. Carga inicial del Selector de Categorías e Inventario completo
    $daoCategoria = new categoriaDAO($db);
    $categorias = $daoCategoria->listarTodos();

} catch (Exception $e) {
    echo "Error al inicializar la aplicación: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Aplicación de Objetos Perdidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    
    <style>
        /* Modales e interactividad no presentes en estilo.css */
        .modal { 
            display: none; 
            position: fixed; 
            z-index: 2000; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0,0,0,0.7); 
            backdrop-filter: blur(4px);
        }
        .modal-content { 
            background-color: #fff; 
            margin: 8% auto; 
            padding: 30px; 
            border-radius: 12px; 
            width: 90%;
            max-width: 500px; 
            position: relative; 
            text-align: center; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            color: #1a1a1a;
        }
        .close-btn { 
            position: absolute; 
            right: 20px; 
            top: 15px; 
            font-size: 28px; 
            cursor: pointer; 
            color: #aaa; 
            transition: color 0.2s ease;
        }
        .close-btn:hover { color: #0046c7; }
        
        .obj-grid-title {
            margin-top: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #002b80;
        }
        
        .buscador-contenedor { 
            margin: 25px auto; 
            text-align: center; 
        }
        .buscador-contenedor select { 
            padding: 10px 20px; 
            font-size: 1rem; 
            border-radius: 25px; 
            border: 2px solid #0056f0; 
            outline: none;
            background-color: white;
            color: #002b80;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <header class="hero">
        <nav class="navbar">
            <div class="auth-buttons">
                <a href="#" class="btn btn-nav btn-outline">Iniciar Sesión</a>
                <a href="#" class="btn btn-nav btn-outline">Registrarse</a>
            </div>
        </nav>
        
        <div class="hero-content">
            <h1><i class="fa-solid fa-magnifying-glass"></i> Tecnolost</h1>
            <h2>Panel de Control y Visualización de Objetos</h2>
            <p class="hero-description">
                Bienvenido al sistema inteligente de gestión. Filtra, encuentra y reporta pertenencias extraviadas de forma rápida y centralizada.
            </p>
        </div>
    </header>

    <main class="recent-objects">
        <div class="container">
            <h3>Objetos Encontrados <span>Hoy</span></h3>
            <hr class="divider">
            
            <div class="objects-grid">
                <?php if (!empty($objetosDeHoy)): ?>
                    <?php foreach ($objetosDeHoy as $obj): ?>
                        <div class="object-circle" onclick="abrirModalDetalle(
                            '<?php echo htmlspecialchars($obj->getNombre(), ENT_QUOTES); ?>', 
                            '<?php echo htmlspecialchars($obj->getDescripcion() ?? '', ENT_QUOTES); ?>', 
                            '<?php echo htmlspecialchars($obj->getColor() ?? '', ENT_QUOTES); ?>', 
                            '<?php echo htmlspecialchars($obj->getMarca() ?? '', ENT_QUOTES); ?>', 
                            '<?php echo $obj->getFechaEncontrado(); ?>', 
                            '<?php echo htmlspecialchars($obj->getFoto() ?? 'img/default.png', ENT_QUOTES); ?>'
                        )">
                            <img src="<?php echo $obj->getFoto() ? htmlspecialchars($obj->getFoto()) : 'img/default.png'; ?>" alt="<?php echo htmlspecialchars($obj->getNombre()); ?>">
                            <p class="obj-grid-title"><?php echo htmlspecialchars($obj->getNombre()); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #666; width: 100%;">No se han reportado objetos en el día de hoy.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <section id="caracteristicas" class="inventory-section">
        <div class="container">
            <div class="inventory-card">
                <h3>Inventario completo</h3>
                <p>Usa los filtros rápidos por categoría o escribe palabras clave para dar con tus pertenencias rápidamente.</p>
                
                <div class="search-container">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" id="inputBusqueda" placeholder="Busca por nombre o descripción de pertenencia...">
                </div>

                <div class="buscador-contenedor">
                    <label for="selectCategoria" style="font-weight: bold; margin-right: 10px; color: #ffffff;">Filtrar por Categoría:</label>
                    <select id="selectCategoria" name="categoria">
                        <option value="">Todas las categorías</option>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat->getIdCategoria(); ?>">
                                    <?php echo htmlspecialchars($cat->getNombre()); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="objects-grid" id="gridPertenencias" style="margin-top: 30px;">
                    <?php if (!empty($todosLosObjetos)): ?>
                        <?php foreach ($todosLosObjetos as $obj): ?>
                            <div class="object-circle" onclick="abrirModalDetalle(
                                '<?php echo htmlspecialchars($obj->getNombre(), ENT_QUOTES); ?>', 
                                '<?php echo htmlspecialchars($obj->getDescripcion() ?? '', ENT_QUOTES); ?>', 
                                '<?php echo htmlspecialchars($obj->getColor() ?? '', ENT_QUOTES); ?>', 
                                '<?php echo htmlspecialchars($obj->getMarca() ?? '', ENT_QUOTES); ?>', 
                                '<?php echo $obj->getFechaEncontrado(); ?>', 
                                '<?php echo htmlspecialchars($obj->getFoto() ?? 'img/default.png', ENT_QUOTES); ?>'
                            )">
                                <img src="<?php echo $obj->getFoto() ? htmlspecialchars($obj->getFoto()) : 'img/default.png'; ?>" alt="<?php echo htmlspecialchars($obj->getNombre()); ?>">
                                <p class="obj-grid-title" style="color: #ffffff;"><?php echo htmlspecialchars($obj->getNombre()); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center; color: #fff; width: 100%;">No hay objetos registrados en el inventario.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="process-section">
        <div class="container">
            <h3>¿Cómo recuperar un objeto?</h3>
            <hr class="divider-white">
            <p class="process-subtitle">Sigue estos tres sencillos pasos para reclamar una pertenencia</p>
            
            <div class="process-grid">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <div class="step-text">
                        <h4>Identifica tu Objeto</h4>
                        <p>Busca en nuestro catálogo interactivo el elemento que extraviaste filtrando por categorías o usando el buscador.</p>
                    </div>
                </div>
                <div class="process-step">
                    <div class="step-number">2</div>
                    <div class="step-text">
                        <h4>Inicia el Reclamo</h4>
                        <p>Presiona sobre el objeto para ver los detalles y acércate al administrador con la información del elemento.</p>
                    </div>
                </div>
                <div class="process-step">
                    <div class="step-number">3</div>
                    <div class="step-text">
                        <h4>Validación y Retiro</h4>
                        <p>Una vez verificada la propiedad por el personal en la biblioteca, se te hará entrega inmediata del mismo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="modalDetalleObjeto" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="cerrarModalDetalle()">&times;</span>
            <h2 id="modalNombre" style="margin-bottom: 15px; color: #0046c7;">Nombre del Objeto</h2>
            <img id="modalFoto" src="img/default.png" alt="Foto" style="border-radius: 8px; margin-bottom: 20px; width: 100%; max-width: 220px; height: 220px; object-fit: cover; border: 3px solid #0046c7;">
            
            <div style="text-align: left; max-width: 90%; margin: 0 auto; line-height: 1.8; font-size: 0.95rem;">
                <p><strong style="color: #002b80;"><i class="fa-solid fa-align-left"></i> Descripción:</strong> <span id="modalDescripcion">Sin descripción.</span></p>
                <p><strong style="color: #002b80;"><i class="fa-solid fa-palette"></i> Color:</strong> <span id="modalColor">No especificado</span></p>
                <p><strong style="color: #002b80;"><i class="fa-solid fa-copyright"></i> Marca:</strong> <span id="modalMarca">Desconocida</span></p>
                <p><strong style="color: #002b80;"><i class="fa-solid fa-calendar-days"></i> Encontrado el:</strong> <span id="modalFecha">-</span></p>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2026 Tecnolost - Sistema de Gestión de Objetos Perdidos. Todos los derechos reservados. Diseñado por Dante.</p>
        </div>
    </footer>

    <script>
        const selectCategoria = document.getElementById('selectCategoria');
        const inputBusqueda = document.getElementById('inputBusqueda');

        // Escuchar tanto el cambio de select como la escritura en el input
        selectCategoria.addEventListener('change', ejecutarFiltro);
        inputBusqueda.addEventListener('input', ejecutarFiltro);

        function ejecutarFiltro() {
            const idCategoria = selectCategoria.value;
            const textoBusqueda = inputBusqueda.value.trim();
            const gridPertenencias = document.getElementById('gridPertenencias');

            // Enviamos ambos parámetros al backend (Asegúrate de actualizar tu buscar.php para recibir texto si lo deseas)
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
                            const nombreSanitizado = (obj.nombre || '').replace(/'/g, "\\'");
                            const descSanitizada = (obj.descripcion || '').replace(/'/g, "\\'");
                            const colorSanitizado = (obj.color || '').replace(/'/g, "\\'");
                            const marcaSanitizado = (obj.marca || '').replace(/'/g, "\\'");
                            const fotoRuta = obj.foto ? obj.foto : 'img/default.png';

                            htmlResultado += `
                                <div class="object-circle" onclick="abrirModalDetalle('${nombreSanitizado}', '${descSanitizada}', '${colorSanitizado}', '${marcaSanitizado}', '${obj.fecha_encontrado}', '${fotoRuta}')">
                                    <img src="${fotoRuta}" alt="${obj.nombre}">
                                    <p class="obj-grid-title" style="color: #ffffff;">${obj.nombre}</p>
                                </div>
                            `;
                        });
                    } else {
                        htmlResultado = "<p style='text-align: center; color: #ffffff; width: 100%; background: #001f66; padding: 15px; border-radius: 8px;'>No se encontraron objetos con los criterios seleccionados.</p>";
                    }

                    gridPertenencias.innerHTML = htmlResultado;
                })
                .catch(err => {
                    console.error("Error:", err);
                    gridPertenencias.innerHTML = "<p style='color: #ff9999; text-align: center; width:100%;'>Error al procesar la búsqueda.</p>";
                });
        }

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
    </script>
</body>
</html>