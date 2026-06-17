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
    
    $todosLosObjetos = $daoObjeto->listarTodos(); 
    if (!empty($todosLosObjetos)) {
        foreach ($todosLosObjetos as $obj) {
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
    <link rel="stylesheet" href="css/cliente/paginaprincipal.css">
    <link rel="stylesheet" href="css/cliente/detalles.css">
</head>
<body>

    <header class="hero">
        <div class="container">
            <nav class="navbar">
                <div class="auth-buttons">
                    <a href="#" class="btn btn-nav btn-outline">Explorar</a>
                    <a href="#" class="btn btn-nav btn-outline">Admin</a>
                </div>
            </nav>
        </div>
        
        <div class="hero-content">
            <h1><i class="fa-solid fa-magnifying-glass"></i> Tecnolost</h1>
            <h2>Panel de Control y Visualización de Objetos</h2>
            <p class="hero-description">
                Bienvenido al sistema inteligente de gestión. Filtra, encuentra y reporta pertenencias extraviadas de forma rápida y centralizada.
            </p>
        </div>
    </header>

    <svg class="wave" viewBox="0 0 1440 120" preserveAspectRatio="none">
        <path fill="var(--primary-blue)" d="M0,0 H1440 V108 C1240,94 1160,66 1010,38 C820,2 560,34 335,58 C190,75 70,104 0,82 Z"></path>
    </svg>

    <main class="recent-objects-carousel" id="carouselContainer">
        <div class="carousel-header-overlay">
            <h3>Objetos Encontrados <span>Hoy</span></h3>
            <hr class="divider">
        </div>
        
        <div class="carousel-track" id="carouselTrack">
            <?php if (!empty($objetosDeHoy)): ?>
                <?php foreach ($objetosDeHoy as $obj): ?>
                    <?php $fotoRuta = $obj->getFoto() ? $obj->getFoto() : 'img/default.png'; ?>
                    <div class="carousel-item" data-id="<?php echo $obj->getIdObjeto(); ?>">
                        <div class="object-circle-carousel">
                            <img src="<?php echo htmlspecialchars($fotoRuta); ?>" alt="<?php echo htmlspecialchars($obj->getNombre()); ?>">
                        </div>
                        <p class="obj-carousel-title"><?php echo htmlspecialchars($obj->getNombre()); ?></p>
                    </div>
                <?php endforeach; ?>
               
                <?php foreach ($objetosDeHoy as $obj): ?>
                    <?php $fotoRuta = $obj->getFoto() ? $obj->getFoto() : 'img/default.png'; ?>
                    <div class="carousel-item" data-id="<?php echo $obj->getIdObjeto(); ?>">
                        <div class="object-circle-carousel">
                            <img src="<?php echo htmlspecialchars($fotoRuta); ?>" alt="<?php echo htmlspecialchars($obj->getNombre()); ?>">
                        </div>
                        <p class="obj-carousel-title"><?php echo htmlspecialchars($obj->getNombre()); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-objects-message">No se han reportado objetos en el día de hoy.</p>
            <?php endif; ?>
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
                    <label for="selectCategoria">Filtrar por Categoría:</label>
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

                <div class="objects-grid" id="gridPertenencias">
                    <?php if (!empty($todosLosObjetos)): ?>
                        <?php foreach ($todosLosObjetos as $obj): ?>
                            <?php $fotoGrid = $obj->getFoto() ? $obj->getFoto() : 'img/default.png'; ?>
                            <div class="object-circle" data-id="<?php echo $obj->getIdObjeto(); ?>">
                                <img src="<?php echo htmlspecialchars($fotoGrid); ?>" alt="<?php echo htmlspecialchars($obj->getNombre()); ?>">
                                <p class="obj-grid-title"><?php echo htmlspecialchars($obj->getNombre()); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-inventory-message">No hay objetos registrados en el inventario.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="process-section">
        <div class="container">
            <h3>¿Cómo recuperar un objecto?</h3>
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

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2026 Tecnolost - Sistema de Gestión de Objetos Perdidos. Todos los derechos reservados. Diseñado por Dante.</p>
        </div>
    </footer>

    <script src="js/Inicio.filtro-carrusel.js"></script>
    <script src="js/cliente/detalles-objeto.js"></script>
</body>
</html>