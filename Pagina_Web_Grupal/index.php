<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnolost - Aplicación de Objetos Perdidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

    <header class="hero">
        <div class="container">
            <nav class="navbar">
                <div class="logo"></div> <div class="auth-buttons">
                    <a href="#" class="btn btn-nav">Admin</a>
                    <a href="#" class="btn btn-nav btn-outline">Registrar</a>
                </div>
            </nav>

            <div class="hero-content">
                <h1>Tecnolost</h1>
                <h2>Aplicación de objetos perdidos</h2>
                
                <div class="hero-ctas">
                    <a href="#caracteristicas" class="btn btn-hero">Características</a>
                    <a href="#sobre-nosotros" class="btn btn-hero">Sobre Nosotros</a>
                </div>

                <p class="hero-description">
                    ¿Perdiste tu cartuchera, abrigo o celular en el instituto? No te preocupes. 
                    Registramos todo lo que se encuentra en las aulas para que puedas reclamarlo 
                    de inmediato de manera organizada y segura.
                </p>
            </div>
        </div>
    </header>

    <main>
        <section class="recent-objects">
            <div class="container">
                <h3>Objetos perdidos <span>recientemente</span></h3>
                <hr class="divider">
                
                <div class="objects-grid">
                    <div class="object-circle">
                        <img src="https://via.placeholder.com/150" alt="Termo Negro">
                    </div>
                    <div class="object-circle">
                        <img src="https://via.placeholder.com/150" alt="Cuaderno a rayas">
                    </div>
                    <div class="object-circle">
                        <img src="https://via.placeholder.com/150" alt="Calculadora Científica">
                    </div>
                    <div class="object-circle">
                        <img src="https://via.placeholder.com/150" alt="Estuche/Funda">
                    </div>
                </div>
            </div>
        </section>

        <section id="caracteristicas" class="inventory-section">
            <div class="container">
                <div class="inventory-card">
                    <h3>Inventario completo</h3>
                    <p>Usa los filtros rápidos o escribe palabras clave para dar con tus pertenencias rápidamente.</p>
                    
                    <div class="search-container">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" placeholder="Busca por nombre, descripción o lugar de pérdida...">
                    </div>

                    <div class="filter-tags">
                        <button class="tag active">Todos</button>
                        <button class="tag">Tecnología</button>
                        <button class="tag">Documentos</button>
                        <button class="tag">Útiles Escolares</button>
                        <button class="tag">Ropa/Accesorios</button>
                        <button class="tag">Otros</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="process-section">
            <div class="container">
                <h3>Proceso de recuperación ¿Cómo funciona?</h3>
                <hr class="divider-white">
                <p class="process-subtitle">Un procedimiento rápido, transparente y seguro para recuperar lo que perdiste.</p>

                <div class="process-grid">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <div class="step-text">
                            <h4>Busca tu objeto</h4>
                            <p>Explora la sección de inventarios o usa el buscador con filtros avanzados.</p>
                        </div>
                    </div>

                    <div class="process-step">
                        <div class="step-number">2</div>
                        <div class="step-text">
                            <h4>Solicita Devolución</h4>
                            <p>Presiona el botón "Solicitar" e ingresa tus datos (Nombre, Turno, etc.) en el formulario.</p>
                        </div>
                    </div>

                    <div class="process-step">
                        <div class="step-number">3</div>
                        <div class="step-text">
                            <h4>Revisión de Solicitud</h4>
                            <p>El encargado del área validará tu solicitud para evitar confusiones de pertenencia.</p>
                        </div>
                    </div>

                    <div class="process-step">
                        <div class="step-number">4</div>
                        <div class="step-text">
                            <h4>Retira tus Objetos</h4>
                            <p>Una vez aprobada la solicitud, acércate a la biblioteca escolar para retirar tu objeto.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="sobre-nosotros" class="about-section">
            <div class="container about-grid">
                <div class="about-content">
                    <h3>Sobre Nosotros</h3>
                    <p>Tecnolost nació con el propósito de transformar la complejidad y el desorden del sector de pertenencias en un proceso ágil, transparente y seguro. Entendemos el valor de tus materiales como tecnología, documentación y útiles, y por eso mismo nos esforzamos en devolver la tranquilidad a la comunidad.</p>
                    <p>De manera eficiente, nuestro objetivo es mantenerte informado sobre qué objetos se encuentran y en qué condiciones, optimizando el tiempo tanto de los administradores como de los alumnos, brindando una plataforma de confianza y profesional que devuelva, ante todo, la tranquilidad a nuestra comunidad.</p>
                </div>
                <div class="about-image-container">
                    <img src="https://via.placeholder.com/400" alt="Equipo de trabajo Tecnolost" class="about-img">
                </div>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2026 Todos los derechos reservados. Diseñado por Dante.</p>
        </div>
    </footer>

</body>
</html>