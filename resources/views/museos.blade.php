<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museos - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                @auth
                    <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                    <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                    <li><a href="{{ route('perfil') }}">Perfil</a></li>
                    <li><a href="{{ route('perfil') }}">Hola, {{ Auth::user()->nombre_apellidos }}</a></li>
                @else
                    <li><a href="#" onclick="openLoginModal(event)">Crear Plan</a></li>
                    <li><a href="#" onclick="openLoginModal(event)">Mis Planes</a></li>
                    <li><a href="#" onclick="openLoginModal(event)">Perfil</a></li>
                    <li><a href="#" onclick="openLoginModal(event)">Iniciar Sesión</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <section class="hotels-section">
        <div class="hotels-container">
            <div class="hotels-header">
                <h1>Museos y Galerías</h1>
                <p class="subtitle">Explora los mejores museos y espacios culturales disponibles</p>
            </div>

            <div class="hotels-filters">
            </div>

            <div id="museums-grid" class="hotels-grid">
                @if($museums->isEmpty())
                    <div class="placeholder-container">
                        <p class="placeholder-text">Selecciona una provincia para ver los museos disponibles</p>
                    </div>
                @else
                    @foreach($museums as $museum)
                        <div class="hotel-card">
                            <div class="hotel-header">
                                <div class="hotel-title">
                                    <h3>{{ $museum->name }}</h3>
                                    <p class="hotel-location">📍 {{ $museum->locality }}, {{ $museum->province }}</p>
                                </div>
                            </div>

                            <div class="hotel-body">
                                @if($museum->museum_type)
                                    <p class="hotel-classification">
                                        <strong>Tipo:</strong> {{ $museum->museum_type }}
                                    </p>
                                @endif

                                @if($museum->address)
                                    <p class="hotel-address">
                                        <strong>Dirección:</strong> {{ $museum->address }}
                                    </p>
                                @endif

                                @if($museum->postal_code)
                                    <p class="hotel-postal">
                                        <strong>Código Postal:</strong> {{ $museum->postal_code }}
                                    </p>
                                @endif

                                <div class="hotel-contact">
                                    @if($museum->phone)
                                        <p>
                                            <strong>📞 Teléfono:</strong>
                                            <a href="tel:{{ $museum->phone }}">{{ $museum->phone }}</a>
                                        </p>
                                    @endif

                                    @if($museum->email)
                                        <p>
                                            <strong>📧 Email:</strong>
                                            <a href="mailto:{{ $museum->email }}">{{ $museum->email }}</a>
                                        </p>
                                    @endif

                                    @if($museum->website)
                                        <p>
                                            <strong>🌐 Sitio Web:</strong>
                                            <a href="{{ $museum->website }}" target="_blank">Visitar web</a>
                                        </p>
                                    @endif
                                </div>

                                @if($museum->description)
                                    <p class="hotel-description">{{ $museum->description }}</p>
                                @endif
                            </div>

                            <div class="hotel-footer">
                                <div class="hotel-rating">
                                    @if($museum->rating)
                                        <span class="rating-stars">⭐ {{ $museum->rating }}/5.0</span>
                                    @endif
                                    @if($museum->reviews_count > 0)
                                        <span class="reviews-count">({{ $museum->reviews_count }} reseñas)</span>
                                    @endif
                                </div>
                                <a href="{{ $museum->website ?? '#' }}" class="btn-small" target="_blank">
                                    📅 Más info
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div id="no-results" class="no-results-message" style="display: none;">
                <p>No se encontraron museos para la selección realizada.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script>
        // Almacenar todos los museos en memoria
        const todosMuseos = @json($museums);

        function filtrarPorLocalidad() {
            const localitySelect = document.getElementById('locality-select');
            const localidadSeleccionada = localitySelect.value;

            if (!localidadSeleccionada) {
                mostrarTodos();
                return;
            }

            const museosFiltrados = todosMuseos.filter(museum => 
                museum.locality === localidadSeleccionada
            );

            if (museosFiltrados.length === 0) {
                document.getElementById('museums-grid').innerHTML = '';
                document.getElementById('no-results').style.display = 'block';
                return;
            }

            document.getElementById('no-results').style.display = 'none';
            mostrarMuseos(museosFiltrados);
        }

        function mostrarTodos() {
            const museumsGrid = document.getElementById('museums-grid');
            
            if (todosMuseos.length === 0) {
                museumsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay museos disponibles</p></div>';
                return;
            }

            mostrarMuseos(todosMuseos);
        }

        function mostrarMuseos(museos) {
            const museumsGrid = document.getElementById('museums-grid');
            const noResults = document.getElementById('no-results');
            
            if (museos.length === 0) {
                museumsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay museos disponibles para los filtros seleccionados</p></div>';
                noResults.style.display = 'none';
                return;
            }

            noResults.style.display = 'none';
            let html = '';

            museos.forEach(museum => {
                const phoneLink = museum.phone ? `<p><strong>📞 Teléfono:</strong> <a href="tel:${museum.phone}">${museum.phone}</a></p>` : '';
                const emailLink = museum.email ? `<p><strong>📧 Email:</strong> <a href="mailto:${museum.email}">${museum.email}</a></p>` : '';
                const website = museum.website ? `<p><strong>🌐 Sitio Web:</strong> <a href="${museum.website}" target="_blank">Visitar web</a></p>` : '';

                html += `
                    <div class="hotel-card">
                        <div class="hotel-header">
                            <div class="hotel-title">
                                <h3>${museum.name}</h3>
                                <p class="hotel-location">📍 ${museum.locality}, ${museum.province}</p>
                            </div>
                        </div>

                        <div class="hotel-body">
                            ${museum.museum_type ? `<p class="hotel-classification"><strong>Tipo:</strong> ${museum.museum_type}</p>` : ''}
                            ${museum.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${museum.address}</p>` : ''}
                            ${museum.postal_code ? `<p class="hotel-postal"><strong>Código Postal:</strong> ${museum.postal_code}</p>` : ''}

                            <div class="hotel-contact">
                                ${phoneLink}
                                ${emailLink}
                                ${website}
                            </div>

                            ${museum.description ? `<p class="hotel-description">${museum.description}</p>` : ''}
                        </div>

                        <div class="hotel-footer">
                            <div class="hotel-rating">
                                ${museum.rating ? `<span class="rating-stars">⭐ ${museum.rating}/5.0</span>` : ''}
                                ${museum.reviews_count > 0 ? `<span class="reviews-count">(${museum.reviews_count} reseñas)</span>` : ''}
                            </div>
                            ${museum.website ? `<a href="${museum.website}" class="btn-small" target="_blank">📅 Más info</a>` : `<button class="btn-small" disabled>Sin datos</button>`}
                        </div>
                    </div>
                `;
            });

            museumsGrid.innerHTML = html;
        }

        // Inicializar en carga
        document.addEventListener('DOMContentLoaded', function() {
            mostrarTodos();
        });
    </script>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
