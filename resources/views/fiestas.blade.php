<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiestas y Festivales - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                <li><a href="{{ route('hoteles') }}">Hoteles</a></li>
                <li><a href="{{ route('museos') }}">Museos</a></li>
                <li><a href="{{ route('restaurantes') }}">Restaurantes</a></li>
                <li><a href="{{ route('fiestas') }}">Fiestas</a></li>
                <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <section class="hotels-section">
        <div class="hotels-container">
            <div class="hotels-header">
                <h1>Fiestas y Festivales</h1>
                <p class="subtitle">Descubre las mejores celebraciones y eventos culturales de la región</p>
            </div>

            <div class="hotels-filters">
                <div class="filter-group">
                    <label for="province-select">Selecciona una Provincia</label>
                    <select id="province-select" class="filter-select" onchange="filtrarPorProvincia()">
                        <option value="">-- Todas las provincias --</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province }}">{{ $province }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="locality-select">Selecciona una Localidad</label>
                    <select id="locality-select" class="filter-select" onchange="filtrarPorLocalidad()" disabled>
                        <option value="">-- Todas las localidades --</option>
                    </select>
                </div>
            </div>

            <div id="festivals-grid" class="hotels-grid">
                @if($festivals->isEmpty())
                    <div class="placeholder-container">
                        <p class="placeholder-text">Selecciona una provincia para ver las fiestas disponibles</p>
                    </div>
                @else
                    @foreach($festivals as $festival)
                        <div class="hotel-card">
                            <div class="hotel-header">
                                <div class="hotel-title">
                                    <h3>{{ $festival->name }}</h3>
                                    <p class="hotel-location">📍 {{ $festival->locality }}, {{ $festival->province }}</p>
                                </div>
                            </div>

                            <div class="hotel-body">
                                @if($festival->festival_type)
                                    <p class="hotel-classification">
                                        <strong>Tipo:</strong> {{ $festival->festival_type }}
                                    </p>
                                @endif

                                @if($festival->start_date && $festival->end_date)
                                    <p class="hotel-classification">
                                        <strong>📅 Fechas:</strong> {{ $festival->start_date->format('d/m/Y') }} - {{ $festival->end_date->format('d/m/Y') }}
                                    </p>
                                @elseif($festival->start_date)
                                    <p class="hotel-classification">
                                        <strong>📅 Fecha:</strong> {{ $festival->start_date->format('d/m/Y') }}
                                    </p>
                                @endif

                                @if($festival->time)
                                    <p class="hotel-classification">
                                        <strong>⏰ Horario:</strong> {{ $festival->time }}
                                    </p>
                                @endif

                                @if($festival->price)
                                    <p class="hotel-classification">
                                        <strong>💰 Precio:</strong> {{ $festival->price }}
                                    </p>
                                @endif

                                @if($festival->address)
                                    <p class="hotel-address">
                                        <strong>Dirección:</strong> {{ $festival->address }}
                                    </p>
                                @endif

                                <div class="hotel-contact">
                                    @if($festival->phone)
                                        <p>
                                            <strong>📞 Teléfono:</strong>
                                            <a href="tel:{{ $festival->phone }}">{{ $festival->phone }}</a>
                                        </p>
                                    @endif

                                    @if($festival->email)
                                        <p>
                                            <strong>📧 Email:</strong>
                                            <a href="mailto:{{ $festival->email }}">{{ $festival->email }}</a>
                                        </p>
                                    @endif

                                    @if($festival->website)
                                        <p>
                                            <strong>🌐 Sitio Web:</strong>
                                            <a href="{{ $festival->website }}" target="_blank">Visitar web</a>
                                        </p>
                                    @endif
                                </div>

                                @if($festival->description)
                                    <p class="hotel-description">{{ $festival->description }}</p>
                                @endif
                            </div>

                            <div class="hotel-footer">
                                <div class="hotel-rating">
                                    @if($festival->rating)
                                        <span class="rating-stars">⭐ {{ $festival->rating }}/5.0</span>
                                    @endif
                                    @if($festival->reviews_count > 0)
                                        <span class="reviews-count">({{ $festival->reviews_count }} reseñas)</span>
                                    @endif
                                </div>
                                <a href="{{ $festival->website ?? '#' }}" class="btn-small" target="_blank">
                                    🎉 Más info
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div id="no-results" class="no-results-message" style="display: none;">
                <p>No se encontraron festivales para la selección realizada.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script>
        // Almacenar todos los festivales en memoria
        const todosFestivales = @json($festivals);

        function filtrarPorProvincia() {
            const provinceSelect = document.getElementById('province-select');
            const localitySelect = document.getElementById('locality-select');
            const provinciaSeleccionada = provinceSelect.value;

            localitySelect.innerHTML = '<option value="">-- Todas las localidades --</option>';
            localitySelect.disabled = !provinciaSeleccionada;

            if (!provinciaSeleccionada) {
                mostrarTodos();
                return;
            }

            const localidadesUnicas = {};
            todosFestivales.forEach(festival => {
                if (festival.province === provinciaSeleccionada && festival.locality) {
                    if (!localidadesUnicas[festival.locality]) {
                        localidadesUnicas[festival.locality] = 0;
                    }
                    localidadesUnicas[festival.locality]++;
                }
            });

            const localidadesOrdenadas = Object.keys(localidadesUnicas).sort();
            localidadesOrdenadas.forEach(localidad => {
                const option = document.createElement('option');
                option.value = localidad;
                option.textContent = `${localidad} (${localidadesUnicas[localidad]} festivales)`;
                localitySelect.appendChild(option);
            });

            const festivalesProvincia = todosFestivales.filter(festival => festival.province === provinciaSeleccionada);
            mostrarFestivales(festivalesProvincia);
        }

        function filtrarPorLocalidad() {
            const provinceSelect = document.getElementById('province-select');
            const localitySelect = document.getElementById('locality-select');
            const provinciaSeleccionada = provinceSelect.value;
            const localidadSeleccionada = localitySelect.value;

            if (!provinciaSeleccionada) return;

            if (!localidadSeleccionada) {
                const festivalesProvincia = todosFestivales.filter(festival => festival.province === provinciaSeleccionada);
                mostrarFestivales(festivalesProvincia);
                return;
            }

            const festivalesFiltrados = todosFestivales.filter(festival => 
                festival.province === provinciaSeleccionada && 
                festival.locality === localidadSeleccionada
            );

            if (festivalesFiltrados.length === 0) {
                document.getElementById('festivals-grid').innerHTML = '';
                document.getElementById('no-results').style.display = 'block';
                return;
            }

            document.getElementById('no-results').style.display = 'none';
            mostrarFestivales(festivalesFiltrados);
        }

        function mostrarTodos() {
            if (todosFestivales.length === 0) {
                document.getElementById('festivals-grid').innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay festivales disponibles</p></div>';
                return;
            }
            mostrarFestivales(todosFestivales);
        }

        function mostrarFestivales(festivales) {
            const festivalsGrid = document.getElementById('festivals-grid');
            const noResults = document.getElementById('no-results');
            
            if (festivales.length === 0) {
                festivalsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay festivales disponibles para los filtros seleccionados</p></div>';
                noResults.style.display = 'none';
                return;
            }

            noResults.style.display = 'none';
            let html = '';

            festivales.forEach(festival => {
                const phoneLink = festival.phone ? `<p><strong>📞 Teléfono:</strong> <a href="tel:${festival.phone}">${festival.phone}</a></p>` : '';
                const emailLink = festival.email ? `<p><strong>📧 Email:</strong> <a href="mailto:${festival.email}">${festival.email}</a></p>` : '';
                const website = festival.website ? `<p><strong>🌐 Sitio Web:</strong> <a href="${festival.website}" target="_blank">Visitar web</a></p>` : '';
                
                const fechas = festival.start_date ? `<p class="hotel-classification"><strong>📅 Fechas:</strong> ${new Date(festival.start_date).toLocaleDateString('es-ES')} ${festival.end_date ? ' - ' + new Date(festival.end_date).toLocaleDateString('es-ES') : ''}</p>` : '';
                const time = festival.time ? `<p class="hotel-classification"><strong>⏰ Horario:</strong> ${festival.time}</p>` : '';
                const price = festival.price ? `<p class="hotel-classification"><strong>💰 Precio:</strong> ${festival.price}</p>` : '';

                html += `
                    <div class="hotel-card">
                        <div class="hotel-header">
                            <div class="hotel-title">
                                <h3>${festival.name}</h3>
                                <p class="hotel-location">📍 ${festival.locality}, ${festival.province}</p>
                            </div>
                        </div>

                        <div class="hotel-body">
                            ${festival.festival_type ? `<p class="hotel-classification"><strong>Tipo:</strong> ${festival.festival_type}</p>` : ''}
                            ${fechas}
                            ${time}
                            ${price}
                            ${festival.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${festival.address}</p>` : ''}

                            <div class="hotel-contact">
                                ${phoneLink}
                                ${emailLink}
                                ${website}
                            </div>

                            ${festival.description ? `<p class="hotel-description">${festival.description}</p>` : ''}
                        </div>

                        <div class="hotel-footer">
                            <div class="hotel-rating">
                                ${festival.rating ? `<span class="rating-stars">⭐ ${festival.rating}/5.0</span>` : ''}
                                ${festival.reviews_count > 0 ? `<span class="reviews-count">(${festival.reviews_count} reseñas)</span>` : ''}
                            </div>
                            ${festival.website ? `<a href="${festival.website}" class="btn-small" target="_blank">🎉 Más info</a>` : `<button class="btn-small" disabled>Sin datos</button>`}
                        </div>
                    </div>
                `;
            });

            festivalsGrid.innerHTML = html;
        }

        document.addEventListener('DOMContentLoaded', function() {
            mostrarTodos();
        });
    </script>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
