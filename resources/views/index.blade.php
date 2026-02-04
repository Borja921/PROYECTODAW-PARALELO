<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TravelPlus - Planifica tus viajes por Castilla y León">
    <title>TravelPlus - Planifica tus viajes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('partials.navbar')
    @include('partials.login-modal')

    <!-- HERO ÉPICO -->
    <section class="hero-epic">
        <div class="hero-epic-content">
            <div class="hero-epic-text">
                <span class="hero-label">BIENVENIDO A</span>
                <h1 class="hero-title">Castilla y León</h1>
                <p class="hero-subtitle">Descubre, planifica y vive experiencias inolvidables en la región más rica en patrimonio</p>
                <div class="hero-cta">
                    <a href="{{ route('destinos') }}" class="btn-primary btn-lg">EXPLORAR DESTINOS</a>
                    <a href="#features" class="btn-secondary btn-lg">CONOCER MÁS</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES EDITORIALES -->
    <section class="features-editorial" id="features">
        <div class="features-container">
            <div class="features-header">
                <h2>¿POR QUÉ TRAVELPLUS?</h2>
                <p>Tu compañero perfecto para explorar Castilla y León</p>
            </div>

            <div class="features-grid-4">
                <article class="feature-editorial">
                    <div class="feature-icon-box">🏨</div>
                    <h3>ALOJAMIENTOS</h3>
                    <p>Encuentra los mejores hospedajes seleccionados en cada destino</p>
                </article>

                <article class="feature-editorial">
                    <div class="feature-icon-box">🍽️</div>
                    <h3>GASTRONOMÍA</h3>
                    <p>Descubre restaurantes con sabor auténtico de Castilla y León</p>
                </article>

                <article class="feature-editorial">
                    <div class="feature-icon-box">🎨</div>
                    <h3>CULTURA</h3>
                    <p>Explora museos y espacios dedicados al arte e historia</p>
                </article>

                <article class="feature-editorial">
                    <div class="feature-icon-box">🎉</div>
                    <h3>EXPERIENCIAS</h3>
                    <p>Participa en fiestas, ferias y eventos locales únicos</p>
                </article>
            </div>
        </div>
    </section>

    <!-- HIGHLIGHTS MODERNOS -->
    <section class="highlights-section">
        <div class="highlights-container">
            <h2>EL CORAZÓN DE CASTILLA Y LEÓN</h2>
            
            <div class="highlights-grid">
                <article class="highlight-card">
                    <div class="highlight-number">01</div>
                    <h3>Patrimonio de la Humanidad</h3>
                    <p>Castillos, catedrales y monumentos históricos reconocidos internacionalmente esperan tu visita</p>
                </article>

                <article class="highlight-card">
                    <div class="highlight-number">02</div>
                    <h3>Excelencia Gastronómica</h3>
                    <p>Degusta Denominaciones de Origen, Ribera del Duero y las especialidades más codiciadas</p>
                </article>

                <article class="highlight-card">
                    <div class="highlight-number">03</div>
                    <h3>Paisajes Singulares</h3>
                    <p>De los Picos de Europa a las Hoces del Duratón, naturaleza que te deja sin aliento</p>
                </article>
            </div>
        </div>
    </section>

    <!-- CTA FINAL -->
    <section class="cta-final">
        <div class="cta-content">
            <h2>COMIENZA TU AVENTURA AHORA</h2>
            <p>Crea planes personalizados y descubre todo lo que Castilla y León tiene para ofrecerte</p>
            <a href="{{ route('destinos') }}" class="btn-primary btn-xl">EMPEZAR AHORA</a>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 TravelPlus - Planificando experiencias en Castilla y León</p>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
