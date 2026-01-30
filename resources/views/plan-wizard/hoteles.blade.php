@extends('layouts.app')

@section('content')
<div class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>Alojamientos Hoteleros</h1>
            <p class="subtitle">Explora los hoteles cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
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
                <select id="locality-select" class="filter-select" onchange="filtrarHotelesPorLocalidad()" disabled>
                    <option value="">-- Todas las localidades --</option>
                </select>
            </div>
        </div>

        <div id="hotels-grid" class="hotels-grid">
            @if($hotels->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">No se han encontrado alojamientos para la localidad seleccionada.</p>
                </div>
            @else
                {{-- El JS rellenará las tarjetas dinámicamente usando todosHoteles --}}
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>No se encontraron alojamientos para la localidad seleccionada.</p>
        </div>

        <div style="margin-top:16px;display:flex;gap:8px;">
            <a class="btn-secondary" href="{{ route('planes') }}">Atrás</a>
            <form method="POST" action="{{ route('plan.wizard.hoteles.save') }}" id="selectHotelForm">
                @csrf
                <input type="hidden" name="hotel_id" id="selected_hotel_id" value="{{ $draft['hotel']['id'] ?? '' }}">
                <button type="submit" class="btn-primary">Siguiente</button>
            </form>
        </div>
    </div>
</div>

<script>
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
            const estrellas = '⭐'.repeat(hotel.stars || 0);
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
                        ${hotel.stars ? `<div class="hotel-stars">${estrellas}</div>` : ''}
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

                    <div class="hotel-footer">
                        <div class="hotel-rating">
                            ${hotel.rating ? `<span class="rating-stars">⭐ ${hotel.rating}/5.0</span>` : ''}
                            ${hotel.reviews_count > 0 ? `<span class="reviews-count">(${hotel.reviews_count} reseñas)</span>` : ''}
                        </div>
                        ${hotel.website ? `<a href="${hotel.website}" class="btn-small" target="_blank">📅 Reservar</a>` : `<button class="btn-small" disabled>Sin datos</button>`}
                    </div>
                </div>
            `;
        });

        hotelsGrid.innerHTML = html;

        // After rendering, attach click handlers to hotel cards to select
        document.querySelectorAll('.hotel-card').forEach((card, idx) => {
            card.addEventListener('click', function() {
                // clear previous selection
                document.querySelectorAll('.hotel-card.selected').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                // set hidden input
                const hotelId = hoteles[idx].id;
                document.getElementById('selected_hotel_id').value = hotelId;
            });
        });
    }

    // Inicializar en carga: preseleccionar los valores del draft
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar todos inicialmente y luego filtrar por la provincia del draft
        mostrarTodos();

        const provinceSelect = document.getElementById('province-select');
        const localitySelect = document.getElementById('locality-select');

        if (provinceSelect) {
            provinceSelect.value = '{{ $draft['provincia'] }}';
            filtrarPorProvincia();

            // Si hay un municipio en el draft, seleccionar
            const draftMunicipio = '{{ $draft['municipio'] }}';
            if (draftMunicipio) {
                // Esperar pequeño tick para que opciones se carguen
                setTimeout(() => {
                    localitySelect.value = draftMunicipio;
                    filtrarHotelesPorLocalidad();
                }, 10);
            }
        }

        // Si hay hotel seleccionado en draft, marcarlo
        @if(isset($draft['hotel']) && $draft['hotel']['id'])
            setTimeout(() => {
                const id = '{{ $draft['hotel']['id'] }}';
                // find hotel in rendered list and mark selected
                document.querySelectorAll('.hotel-card').forEach(card => {
                    if (card.innerHTML.includes(id)) {
                        card.classList.add('selected');
                        document.getElementById('selected_hotel_id').value = id;
                    }
                });
            }, 50);
        @endif
    });
</script>

@endsection