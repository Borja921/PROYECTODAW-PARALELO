<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelPlus - Planifica tus viajes</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('partials.navbar')

    @include('partials.login-modal')

    <!-- Sección: Qué es TravelPlus -->
    <section class="about-section">
        <div class="about-container">
            <h1>Descubre Castilla y León como nunca antes</h1>
            <p class="about-lead">
                TravelPlus es tu compañero perfecto para explorar los rincones más fascinantes de Castilla y León. 
                Creamos itinerarios personalizados que te conectan con el patrimonio histórico, la gastronomía excepcional 
                y las experiencias únicas que solo esta tierra milenaria puede ofrecer.
            </p>
            <div class="about-highlights">
                <div class="highlight-item">
                    <span class="highlight-icon">🏰</span>
                    <h3>Patrimonio Mundial</h3>
                    <p>Castillos, catedrales y monumentos declarados Patrimonio de la Humanidad te esperan en cada provincia</p>
                </div>
                <div class="highlight-item">
                    <span class="highlight-icon">🍷</span>
                    <h3>Gastronomía de Excelencia</h3>
                    <p>Degusta los mejores vinos de Ribera del Duero, el lechazo asado y productos con Denominación de Origen</p>
                </div>
                <div class="highlight-item">
                    <span class="highlight-icon">🌄</span>
                    <h3>Naturaleza Virgen</h3>
                    <p>Desde los Picos de Europa hasta las Hoces del Duratón, paisajes que te dejarán sin aliento</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Por qué usar TravelPlus -->
    <section class="features">
        <h2>¿Por qué usar TravelPlus?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon">🏨</span>
                <h3>Hoteles</h3>
                <p>Encuentra los mejores hospedajes en cualquier destino</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🍽️</span>
                <h3>Restaurantes</h3>
                <p>Descubre la gastronomía local de cada región</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🎨</span>
                <h3>Museos</h3>
                <p>Explora la cultura y arte de cada lugar</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🎪</span>
                <h3>Atracciones</h3>
                <p>Actividades y entretenimiento para todos</p>
            </div>
        </div>
    </section>

    <!-- Sección: Descubre tu próximo destino -->
    <section class="hero">
        <div class="hero-content">
            <h1>Descubre tu próximo destino</h1>
            <p>Planifica viajes inolvidables por Castilla y León en minutos</p>
            <a href="{{ route('destinos') }}" class="btn-primary">Explorar Destinos</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
