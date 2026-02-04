<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Alojamientos en Castilla y León - Hoteles, hostales y hospedajes">
    <title>Alojamientos Hoteleros - TravelPlus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('partials.navbar')

    <!-- HERO HOTELES -->
    <section class="hero-hotels">
        <div class="hero-hotels-content">
            <span class="hero-label">ALOJAMIENTOS</span>
            <h1>TU HOGAR EN<br>CASTILLA Y LEÓN</h1>
            <p>Descubre hospedajes selectos en cada rincón de la región</p>
        </div>
    </section>

    <!-- CONTENEDOR HOTELES MODERNO -->
    <section class="hotels-section hotels-modern">
        <div class="hotels-container">
            <div class="hotels-header">
                <h2>ALOJAMIENTOS DISPONIBLES</h2>
                <p>Filtra por provincia y localidad para encontrar tu hospedaje perfecto</p>
            </div>

            <div class="hotels-filters">
            </div>

            <div id="hotels-grid" class="hotels-grid">
                @if($hotels->isEmpty())
                    <div class="placeholder-container">
                        <p class="placeholder-text">Selecciona una localidad para ver los alojamientos disponibles</p>
                    </div>
                @else
                    @foreach($hotels as $hotel)
                        <div class="hotel-card">
                            <div class="hotel-header">
                                <div class="hotel-title">
                                    <h3>{{ $hotel->name }}</h3>
                                    <p class="hotel-location">📍 {{ $hotel->locality }}, {{ $hotel->province }}</p>
                                </div>
                            </div>

                            <div class="hotel-body">
                                @if($hotel->classification)
                                    <p class="hotel-classification">
                                        <strong>Clasificación:</strong> {{ $hotel->classification }}
                                    </p>
                                @endif

                                @if($hotel->address)
                                    <p class="hotel-address">
                                        <strong>Dirección:</strong> {{ $hotel->address }}
                                    </p>
                                @endif

                                @if($hotel->postal_code)
                                    <p class="hotel-postal">
                                        <strong>Código Postal:</strong> {{ $hotel->postal_code }}
                                    </p>
                                @endif

                                @if($hotel->num_rooms)
                                    <p class="hotel-rooms">
                                        <strong>Habitaciones:</strong> {{ $hotel->num_rooms }}
                                    </p>
                                @endif

                                <div class="hotel-contact">
                                    @if($hotel->phone)
                                        <p>
                                            <strong>📞 Teléfono:</strong>
                                            <a href="tel:{{ $hotel->phone }}">{{ $hotel->phone }}</a>
                                        </p>
                                    @endif

                                    @if($hotel->email)
                                        <p>
                                            <strong>📧 Email:</strong>
                                            <a href="mailto:{{ $hotel->email }}">{{ $hotel->email }}</a>
                                        </p>
                                    @endif

                                    @if($hotel->website)
                                        <p>
                                            <strong>🌐 Sitio Web:</strong>
                                            <a href="{{ $hotel->website }}" target="_blank">Visitar web</a>
                                        </p>
                                    @endif
                                </div>

                                @if($hotel->description)
                                    <p class="hotel-description">{{ $hotel->description }}</p>
                                @endif
                            </div>

                            <div class="hotel-footer">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div id="no-results" class="no-results-message" style="display: none;">
                <p>No se encontraron alojamientos para la localidad seleccionada.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 TravelPlus - Tu compañero en Castilla y León</p>
        </div>
    </footer>

    @include('partials.login-modal')

    <script>
        // Almacenar todos los hoteles en memoria
        const todosHoteles = @json($hotels);

        function filtrarPorProvincia() {
            const provinceSelect = document.getElementById('province-select');
            const localitySelect = document.getElementById('locality-select');
            const provinciaSeleccionada = provinceSelect.value;

            // Limpiar selector de localidades
            localitySelect.innerHTML = '<option value="">-- Todas las localidades --</option>';
            localitySelect.disabled = !provinciaSeleccionada;

            if (!provinciaSeleccionada) {
                // Mostrar todos los hoteles si no hay provincia seleccionada
                mostrarTodos();
                return;
            }

            // Obtener localidades de la provincia seleccionada
            const localidadesUnicas = {};
            todosHoteles.forEach(hotel => {
                if (hotel.province === provinciaSeleccionada && hotel.locality) {
                    if (!localidadesUnicas[hotel.locality]) {
                        localidadesUnicas[hotel.locality] = 0;
                    }
                    localidadesUnicas[hotel.locality]++;
                }
            });

            // Agregar localidades al selector
            const localidadesOrdenadas = Object.keys(localidadesUnicas).sort();
            localidadesOrdenadas.forEach(localidad => {
                const option = document.createElement('option');
                option.value = localidad;
                option.textContent = `${localidad} (${localidadesUnicas[localidad]} hoteles)`;
                localitySelect.appendChild(option);
            });

            // Mostrar hoteles de la provincia (todas las localidades)
            const hotelesProvincia = todosHoteles.filter(hotel => hotel.province === provinciaSeleccionada);
            mostrarHoteles(hotelesProvincia);
        }

        function filtrarHotelesPorLocalidad() {
            const provinceSelect = document.getElementById('province-select');
            const localitySelect = document.getElementById('locality-select');
            const provinciaSeleccionada = provinceSelect.value;
            const localidadSeleccionada = localitySelect.value;

            if (!provinciaSeleccionada) {
                // Si no hay provincia seleccionada, no hacer nada
                return;
            }

            if (!localidadSeleccionada) {
                // Mostrar todos los hoteles de la provincia
                const hotelesProvincia = todosHoteles.filter(hotel => hotel.province === provinciaSeleccionada);
                mostrarHoteles(hotelesProvincia);
                return;
            }

            // Filtrar por provincia Y localidad
            const hotelesFiltrados = todosHoteles.filter(hotel =>
                hotel.province === provinciaSeleccionada &&
                hotel.locality === localidadSeleccionada
            );

            if (hotelesFiltrados.length === 0) {
                const noResults = document.getElementById('no-results');
                document.getElementById('hotels-grid').innerHTML = '';
                noResults.style.display = 'block';
                return;
            }

            document.getElementById('no-results').style.display = 'none';
            mostrarHoteles(hotelesFiltrados);
        }

        function mostrarTodos() {
            const hotelsGrid = document.getElementById('hotels-grid');
            const noResults = document.getElementById('no-results');

            if (todosHoteles.length === 0) {
                hotelsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay hoteles disponibles</p></div>';
                noResults.style.display = 'none';
                return;
            }

            noResults.style.display = 'none';
            mostrarHoteles(todosHoteles);
        }

        function mostrarHoteles(hoteles) {
            const hotelsGrid = document.getElementById('hotels-grid');
            const noResults = document.getElementById('no-results');

            if (hoteles.length === 0) {
                hotelsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay hoteles disponibles para los filtros seleccionados</p></div>';
                noResults.style.display = 'none';
                return;
            }

            noResults.style.display = 'none';
            let html = '';

            hoteles.forEach(hotel => {
                const phoneLink = hotel.phone ? `<p><strong>📞 Teléfono:</strong> <a href="tel:${hotel.phone}">${hotel.phone}</a></p>` : '';
                const emailLink = hotel.email ? `<p><strong>📧 Email:</strong> <a href="mailto:${hotel.email}">${hotel.email}</a></p>` : '';
                const website = hotel.website ? `<p><strong>🌐 Sitio Web:</strong> <a href="${hotel.website}" target="_blank">Visitar web</a></p>` : '';

                html += `
                    <div class="hotel-card">
                        <div class="hotel-header">
                            <div class="hotel-title">
                                <h3>${hotel.name}</h3>
                                <p class="hotel-location">📍 ${hotel.locality}, ${hotel.province}</p>
                            </div>
                        </div>

                        <div class="hotel-body">
                            ${hotel.classification ? `<p class="hotel-classification"><strong>Clasificación:</strong> ${hotel.classification}</p>` : ''}
                            ${hotel.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${hotel.address}</p>` : ''}
                            ${hotel.postal_code ? `<p class="hotel-postal"><strong>Código Postal:</strong> ${hotel.postal_code}</p>` : ''}
                            ${hotel.num_rooms ? `<p class="hotel-rooms"><strong>Habitaciones:</strong> ${hotel.num_rooms}</p>` : ''}

                            <div class="hotel-contact">
                                ${phoneLink}
                                ${emailLink}
                                ${website}
                            </div>

                            ${hotel.description ? `<p class="hotel-description">${hotel.description}</p>` : ''}
                        </div>
                    </div>
                `;
            });

            hotelsGrid.innerHTML = html;
        }

        // Inicializar en carga
        document.addEventListener('DOMContentLoaded', function() {
            mostrarTodos();
        });
    </script>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
