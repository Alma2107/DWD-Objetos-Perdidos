<?php
//iniciamos la sesion de php
//para poder leer si el admin entro
session_start();

//cargamos los archivos necesarios
//para que funcione la base de datos
require_once __DIR__ . '/conexion.php';                 
require_once __DIR__ . '/clases/php/Objeto.php';       
require_once __DIR__ . '/clases/daos/objetoDao.php';   
require_once __DIR__ . '/clases/php/Categoria.php';      
require_once __DIR__ . '/clases/daos/categoriaDao.php';  



try {
    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();

    $daoObjeto = new ObjetoDAO($db);
    

    $objetosDeHoy = [];
    
    $todosLosObjetos = $daoObjeto->listarTodos(); 
    if (!empty($todosLosObjetos)) {
        foreach ($todosLosObjetos as $obj) {
        
            $objetosDeHoy[] = $obj;
        }
    }


    $daoCategoria = new CategoriaDAO($db); 
    $categorias = $daoCategoria->listarTodos();

} catch (Exception $e) {
    echo "Error al inicializar la aplicación: " . $e->getMessage();
    exit;
}

function rutaFotoObjeto($foto) {
    if (!$foto) {
        return 'img/default.png';
    }

    if (preg_match('/^(uploads\/|img\/|https?:\/\/)/', $foto)) {
        return $foto;
    }

    return 'uploads/' . $foto;
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
<body class="modo-inicio">

    <header class="nav-header">
        <div class="container">
            <nav class="navbar">
                <div class="brand" id="btnLogoInicio" style="cursor:pointer;">
                    <h3><i class="fa-solid fa-magnifying-glass"></i> Tecnolost</h3>
                </div>
               <div class="auth-buttons">
                    <button id="btnInicioNav" class="btn btn-nav btn-outline"><i class="fa-solid fa-house"></i> Inicio</button>
                    <button id="btnReclamarNav" class="btn btn-nav btn-reclamar" style="display: none;"><i class="fa-solid fa-hand-holding-hand"></i> Reclamar Objeto</button>
                            
                    <?php 
                        //nos fijamos si existe la sesion
                        //para saber si es el administrador
                        if (isset($_SESSION['idAdmin'])): 
                    ?>
                        <a href="panel_admin/admin_panel.php" class="btn btn-nav btn-outline"><i class="fa-solid fa-user-gear"></i> Admin</a>
                        <a href="consultas_php/admin/cerrar_sesion.php" class="btn btn-nav btn-outline"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
                    <?php 
                        //si no hay sesion activa
                        //le mostramos el boton de entrar
                        else: 
                    ?>
                    <a href="consultas_php/admin/login.php" class="btn btn-nav btn-outline"><i class="fa-solid fa-user-gear"></i> Admin</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <div id="pantalla-principal">
        <section class="hero">
            <div class="hero-content">
                <h1>Tecnolost</h1>
                <h2>Aplicación de objetos perdidos</h2>
                <p class="hero-description">
                    ¿Perdiste tu cartuchera, abrigo o celular en el instituto? Busca lo que se encontro y envia tu solicitud de reclamo de forma organizada.
                </p>
            </div>
        </section>

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
                        <?php $fotoRuta = rutaFotoObjeto($obj->getFoto()); ?>
                        <div class="carousel-item" data-id="<?php echo $obj->getIdObjeto(); ?>">
                            <div class="object-circle-carousel">
                                <img src="<?php echo htmlspecialchars($fotoRuta); ?>" alt="<?php echo htmlspecialchars($obj->getNombre()); ?>">
                            </div>
                            <p class="obj-carousel-title"><?php echo htmlspecialchars($obj->getNombre()); ?></p>
                        </div>
                    <?php endforeach; ?>
                   
                    <?php foreach ($objetosDeHoy as $obj): ?>
                        <?php $fotoRuta = rutaFotoObjeto($obj->getFoto()); ?>
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
                                <?php $fotoGrid = rutaFotoObjeto($obj->getFoto()); ?>
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
                        <p>Presiona sobre el objeto, revisa sus detalles y completa la solicitud con tus datos.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <div class="step-text">
                        <h4>Validación y Retiro</h4>
                        <p>Cuando se revise la solicitud, se coordinara la validacion y entrega del objeto.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="formularioObjetoContenedor" style="display: none;"></div>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2026 Tecnolost - Sistema de Gestión de Objetos Perdidos. Todos los derechos reservados. Diseñado por Dante.</p>
        </div>
    </footer>

    <script src="js/Inicio.filtro-carrusel.js"></script>
    <script src="js/cliente/detalles-objeto.js"></script>
</body>
</html>
