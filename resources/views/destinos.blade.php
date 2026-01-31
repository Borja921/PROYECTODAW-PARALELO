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
            <select class="filter-select" id="selector-provincias">
                <option value="">Todas las provincias</option>
            </select>
        </div>

        <div class="destinations-grid">
            <!-- Provincias de Castilla y León desde la API -->
            <div id="provincias-cyl-grid" class="destinations-grid"></div>
            <script>
            document.addEventListener('DOMContentLoaded', async function() {
                const grid = document.getElementById('provincias-cyl-grid');
                const selector = document.getElementById('selector-provincias');
                let provincias = [];
                const colores = [
                    '#A89B9B', '#9D8B7E', '#C0B5AA', '#8B7B7B', '#D4CCC4', '#B7A99A', '#B2A59B', '#C7B7A3', '#A89B7B'
                ];
                try {
                    const res = await fetch('/api/municipios');
                    const data = await res.json();
                    provincias = Object.keys(data).sort();
                    // Rellenar selector de provincias
                    provincias.forEach(prov => {
                        const opt = document.createElement('option');
                        opt.value = prov;
                        opt.textContent = prov;
                        selector.appendChild(opt);
                    });
                    renderProvincias(provincias);
                } catch (e) {
                    grid.innerHTML = '<p style="color:red">No se pudieron cargar las provincias de Castilla y León.</p>';
                }
                selector.addEventListener('change', function() {
                    if (!selector.value) {
                        renderProvincias(provincias);
                    } else {
                        renderProvincias([selector.value]);
                    }
                });
                function renderProvincias(lista) {
                    let html = '';
                    lista.forEach((prov, idx) => {
                        html += `
                        <div class="destination-card">
                            <div class="destination-image" style="background: linear-gradient(135deg, ${colores[idx%colores.length]}, #9D8B7E);">
                                🏞️
                            </div>
                            <div class="destination-content">
                                <h3>${prov}</h3>
                                <p class="destination-subtitle">Castilla y León</p>
                                <p class="destination-desc">Descubre los mejores destinos de la provincia de ${prov}.</p>
                                <div class="destination-meta">
                                    <span>⭐ 4.8</span>
                                    <span>👥 +1000 visitantes</span>
                                </div>
                                <a href="{{ route('planes') }}?provincia=${encodeURIComponent(prov)}" class="btn-small">Explorar</a>
                            </div>
                        </div>
                        `;
                    });
                    grid.innerHTML = html;
                }
            });
            </script>
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
