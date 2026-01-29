<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelPlus - Planifica tus viajes</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}" class="active">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                <li><a href="{{ route('hoteles') }}">Hoteles</a></li>
                <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Descubre tu próximo destino</h1>
            <p>Planifica viajes increíbles en segundos</p>
            <a href="{{ route('planes') }}" class="btn-primary">Comenzar a Planear</a>
        </div>
    </section>

    <section class="features">
        <h2>¿Por qué elegir TravelPlus?</h2>
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

    <section class="cta">
        <h2>¿Listo para tu próxima aventura?</h2>
        <a href="{{ route('planes') }}" class="btn-secondary">Crear tu primer plan</a>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
