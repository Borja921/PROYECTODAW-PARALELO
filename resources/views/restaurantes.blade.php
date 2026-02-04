@extends('layouts.app')

@section('title', 'Restaurantes - MateCyL')

@section('content')

    <section class="hotels-section">
        <div class="hotels-container">
            <div class="hotels-header">
                <h1>Restaurantes</h1>
                <p class="subtitle">Descubre los mejores restaurantes y establecimientos gastronómicos disponibles</p>
            </div>

            <div class="hotels-filters">
            </div>

            <div id="restaurants-grid" class="hotels-grid">
                @if($restaurants->isEmpty())
                    <div class="placeholder-container">
                        <p class="placeholder-text">Selecciona una provincia para ver los restaurantes disponibles</p>
                    </div>
                @else
                    @foreach($restaurants as $restaurant)
                        <div class="hotel-card">
                            <div class="hotel-header">
                                <div class="hotel-title">
                                    <h3>{{ $restaurant->name }}</h3>
                                    <p class="hotel-location">📍 {{ $restaurant->locality }}, {{ $restaurant->province }}</p>
                                </div>
                            </div>

                            <div class="hotel-body">
                                @if($restaurant->cuisine_type)
                                    <p class="hotel-classification">
                                        <strong>Cocina:</strong> {{ $restaurant->cuisine_type }}
                                    </p>
                                @endif

                                @if($restaurant->price_level)
                                    <p class="hotel-classification">
                                        <strong>Precio:</strong> {{ $restaurant->price_level }}
                                    </p>
                                @endif

                                @if($restaurant->address)
                                    <p class="hotel-address">
                                        <strong>Dirección:</strong> {{ $restaurant->address }}
                                    </p>
                                @endif

                                @if($restaurant->postal_code)
                                    <p class="hotel-postal">
                                        <strong>Código Postal:</strong> {{ $restaurant->postal_code }}
                                    </p>
                                @endif

                                @if($restaurant->opening_hours)
                                    <p class="hotel-classification">
                                        <strong>Horario:</strong> {{ $restaurant->opening_hours }}
                                    </p>
                                @endif

                                <div class="hotel-contact">
                                    @if($restaurant->phone)
                                        <p>
                                            <strong>📞 Teléfono:</strong>
                                            <a href="tel:{{ $restaurant->phone }}">{{ $restaurant->phone }}</a>
                                        </p>
                                    @endif

                                    @if($restaurant->email)
                                        <p>
                                            <strong>📧 Email:</strong>
                                            <a href="mailto:{{ $restaurant->email }}">{{ $restaurant->email }}</a>
                                        </p>
                                    @endif

                                    @if($restaurant->website)
                                        <p>
                                            <strong>🌐 Sitio Web:</strong>
                                            <a href="{{ $restaurant->website }}" target="_blank">Visitar web</a>
                                        </p>
                                    @endif
                                </div>

                                @if($restaurant->description)
                                    <p class="hotel-description">{{ $restaurant->description }}</p>
                                @endif
                            </div>

                            <div class="hotel-footer">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div id="no-results" class="no-results-message" style="display: none;">
                <p>No se encontraron restaurantes para la selección realizada.</p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Almacenar todos los restaurantes en memoria
    const todosRestaurantes = @json($restaurants);

    function filtrarPorProvincia() {
        const provinceSelect = document.getElementById('province-select');
        const localitySelect = document.getElementById('locality-select');
        const provinciaSeleccionada = provinceSelect.value;

        // Limpiar selector de localidades
        localitySelect.innerHTML = '<option value="">-- Todas las localidades --</option>';
        localitySelect.disabled = !provinciaSeleccionada;

        if (!provinciaSeleccionada) {
            mostrarTodos();
            return;
        }

        // Obtener localidades de la provincia seleccionada
        const localidadesUnicas = {};
        todosRestaurantes.forEach(restaurant => {
            if (restaurant.province === provinciaSeleccionada && restaurant.locality) {
                if (!localidadesUnicas[restaurant.locality]) {
                    localidadesUnicas[restaurant.locality] = 0;
                }
                localidadesUnicas[restaurant.locality]++;
            }
        });

        // Agregar localidades al selector
        const localidadesOrdenadas = Object.keys(localidadesUnicas).sort();
        localidadesOrdenadas.forEach(localidad => {
            const option = document.createElement('option');
            option.value = localidad;
            option.textContent = `${localidad} (${localidadesUnicas[localidad]} restaurantes)`;
            localitySelect.appendChild(option);
        });

        // Mostrar restaurantes de la provincia
        const restaurantesProvincia = todosRestaurantes.filter(restaurant => restaurant.province === provinciaSeleccionada);
        mostrarRestaurantes(restaurantesProvincia);
    }

    function filtrarPorLocalidad() {
        const provinceSelect = document.getElementById('province-select');
        const localitySelect = document.getElementById('locality-select');
        const provinciaSeleccionada = provinceSelect.value;
        const localidadSeleccionada = localitySelect.value;

        if (!provinciaSeleccionada) {
            return;
        }

        if (!localidadSeleccionada) {
            const restaurantesProvincia = todosRestaurantes.filter(restaurant => restaurant.province === provinciaSeleccionada);
            mostrarRestaurantes(restaurantesProvincia);
            return;
        }

        const restaurantesFiltrados = todosRestaurantes.filter(restaurant =>
            restaurant.province === provinciaSeleccionada &&
            restaurant.locality === localidadSeleccionada
        );

        if (restaurantesFiltrados.length === 0) {
            document.getElementById('restaurants-grid').innerHTML = '';
            document.getElementById('no-results').style.display = 'block';
            return;
        }

        document.getElementById('no-results').style.display = 'none';
        mostrarRestaurantes(restaurantesFiltrados);
    }

    function mostrarTodos() {
        const restaurantsGrid = document.getElementById('restaurants-grid');

        if (todosRestaurantes.length === 0) {
            restaurantsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay restaurantes disponibles</p></div>';
            return;
        }

        mostrarRestaurantes(todosRestaurantes);
    }

    function mostrarRestaurantes(restaurantes) {
        const restaurantsGrid = document.getElementById('restaurants-grid');
        const noResults = document.getElementById('no-results');

        if (restaurantes.length === 0) {
            restaurantsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay restaurantes disponibles para los filtros seleccionados</p></div>';
            noResults.style.display = 'none';
            return;
        }

        noResults.style.display = 'none';
        let html = '';

        restaurantes.forEach(restaurant => {
            const phoneLink = restaurant.phone ? `<p><strong>📞 Teléfono:</strong> <a href="tel:${restaurant.phone}">${restaurant.phone}</a></p>` : '';
            const emailLink = restaurant.email ? `<p><strong>📧 Email:</strong> <a href="mailto:${restaurant.email}">${restaurant.email}</a></p>` : '';
            const website = restaurant.website ? `<p><strong>🌐 Sitio Web:</strong> <a href="${restaurant.website}" target="_blank">Visitar web</a></p>` : '';

            html += `
                <div class="hotel-card">
                    <div class="hotel-header">
                        <div class="hotel-title">
                            <h3>${restaurant.name}</h3>
                            <p class="hotel-location">📍 ${restaurant.locality}, ${restaurant.province}</p>
                        </div>
                    </div>

                    <div class="hotel-body">
                        ${restaurant.cuisine_type ? `<p class="hotel-classification"><strong>Cocina:</strong> ${restaurant.cuisine_type}</p>` : ''}
                        ${restaurant.price_level ? `<p class="hotel-classification"><strong>Precio:</strong> ${restaurant.price_level}</p>` : ''}
                        ${restaurant.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${restaurant.address}</p>` : ''}
                        ${restaurant.postal_code ? `<p class="hotel-postal"><strong>Código Postal:</strong> ${restaurant.postal_code}</p>` : ''}
                        ${restaurant.opening_hours ? `<p class="hotel-classification"><strong>Horario:</strong> ${restaurant.opening_hours}</p>` : ''}

                        <div class="hotel-contact">
                            ${phoneLink}
                            ${emailLink}
                            ${website}
                        </div>

                        ${restaurant.description ? `<p class="hotel-description">${restaurant.description}</p>` : ''}
                    </div>
                </div>
            `;
        });

        restaurantsGrid.innerHTML = html;
    }

    // Inicializar en carga
    document.addEventListener('DOMContentLoaded', function() {
        mostrarTodos();
    });
</script>
@endpush
