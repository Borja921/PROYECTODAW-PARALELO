<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar Destinos - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}" class="active">Destinos</a></li>
                <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <section class="explore-section">
        <div class="explore-header">
            <h1>Explora Nuestros Destinos</h1>
            <p>Descubre lugares increíbles para tus próximas vacaciones</p>
        </div>

        <div class="explore-filters">
            <input type="text" placeholder="🔍 Buscar destino..." class="search-input">
            <select class="filter-select">
                <option>Todas las provincias</option>
                <option>Madrid</option>
                <option>Barcelona</option>
                <option>Valencia</option>
                <option>Sevilla</option>
                <option>Bilbao</option>
                <option>Málaga</option>
            </select>
            <select class="filter-select">
                <option>Cualquier clima</option>
                <option>Playa</option>
                <option>Montaña</option>
                <option>Ciudad</option>
            </select>
        </div>

        <div class="destinations-grid">
            <!-- Destino 1 -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #A89B9B, #9D8B7E);">
                    🏛️
                </div>
                <div class="destination-content">
                    <h3>Madrid</h3>
                    <p class="destination-subtitle">Comunidad de Madrid</p>
                    <p class="destination-desc">Capital cultural con museos de clase mundial y vida nocturna vibrante</p>
                    <div class="destination-meta">
                        <span>⭐ 4.8</span>
                        <span>👥 15.2k visitantes</span>
                    </div>
                    <a href="{{ route('planes') }}?provincia=Madrid" class="btn-small">Explorar</a>
                </div>
            </div>

            <!-- Destino 2 -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #9D8B7E, #8B7B7B);">
                    🏰
                </div>
                <div class="destination-content">
                    <h3>Barcelona</h3>
                    <p class="destination-subtitle">Cataluña</p>
                    <p class="destination-desc">Ciudad de arquitectura modernista, playas y energía mediterránea</p>
                    <div class="destination-meta">
                        <span>⭐ 4.9</span>
                        <span>👥 18.5k visitantes</span>
                    </div>
                    <a href="{{ route('planes') }}?provincia=Barcelona" class="btn-small">Explorar</a>
                </div>
            </div>

            <!-- Destino 3 -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #C0B5AA, #A89B9B);">
                    🌊
                </div>
                <div class="destination-content">
                    <h3>Valencia</h3>
                    <p class="destination-subtitle">Comunidad Valenciana</p>
                    <p class="destination-desc">Innovación futurista, tradiciones milenarias y deliciosa gastronomía</p>
                    <div class="destination-meta">
                        <span>⭐ 4.7</span>
                        <span>👥 12.3k visitantes</span>
                    </div>
                    <a href="{{ route('planes') }}?provincia=Valencia" class="btn-small">Explorar</a>
                </div>
            </div>

            <!-- Destino 4 -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #8B7B7B, #D4CCC4);">
                    🎭
                </div>
                <div class="destination-content">
                    <h3>Sevilla</h3>
                    <p class="destination-subtitle">Andalucía</p>
                    <p class="destination-desc">Flamenco, pasión andaluza y monumentos históricos impresionantes</p>
                    <div class="destination-meta">
                        <span>⭐ 4.8</span>
                        <span>👥 14.7k visitantes</span>
                    </div>
                    <a href="{{ route('planes') }}?provincia=Sevilla" class="btn-small">Explorar</a>
                </div>
            </div>

            <!-- Destino 5 -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #A89B9B, #C0B5AA);">
                    🎨
                </div>
                <div class="destination-content">
                    <h3>Bilbao</h3>
                    <p class="destination-subtitle">País Vasco</p>
                    <p class="destination-desc">Fusión de arte moderno, tradición vasca y gastronomía de lujo</p>
                    <div class="destination-meta">
                        <span>⭐ 4.7</span>
                        <span>👥 10.9k visitantes</span>
                    </div>
                    <a href="{{ route('planes') }}?provincia=Bilbao" class="btn-small">Explorar</a>
                </div>
            </div>

            <!-- Destino 6 -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #9D8B7E, #A89B9B);">
                    🏖️
                </div>
                <div class="destination-content">
                    <h3>Málaga</h3>
                    <p class="destination-subtitle">Andalucía</p>
                    <p class="destination-desc">Costa del Sol, playas doradas y clima mediterráneo envidiable</p>
                    <div class="destination-meta">
                        <span>⭐ 4.9</span>
                        <span>👥 22.1k visitantes</span>
                    </div>
                    <a href="{{ route('planes') }}?provincia=Málaga" class="btn-small">Explorar</a>
                </div>
            </div>
        </div>

        <div class="featured-section">
            <h2>Destinos Destacados del Mes</h2>
            <div class="featured-grid">
                <div class="featured-card">
                    <div class="featured-badge">🔥 Trending</div>
                    <h3>Ruta del Modernismo en Barcelona</h3>
                    <p>Recorre las obras maestras arquitectónicas de Gaudí y sus contemporáneos</p>
                    <div class="featured-rating">⭐⭐⭐⭐⭐ 5.0 (237 reseñas)</div>
                    <a href="{{ route('planes') }}?provincia=Barcelona" class="btn-small">Ver Plan</a>
                </div>
                <div class="featured-card">
                    <div class="featured-badge">✨ Nuevo</div>
                    <h3>Experiencia Gastronómica Vasca</h3>
                    <p>Déjate seducir por la mejor gastronomía del País Vasco</p>
                    <div class="featured-rating">⭐⭐⭐⭐⭐ 4.9 (189 reseñas)</div>
                    <a href="{{ route('planes') }}?provincia=Bilbao" class="btn-small">Ver Plan</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
