@extends('layouts.app')

@section('content')
<style>
    .hotel-card.selected {
        border: 2px solid #4CAF50;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }
    
    .btn-selected {
        background-color: #4CAF50 !important;
        color: white !important;
        cursor: default !important;
    }
    
    .btn-selected:hover {
        background-color: #45a049 !important;
    }
    
    .btn-small, .btn-select-hotel {
        min-height: 36px;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-primary, .btn-secondary {
        min-height: 42px;
        height: 42px;
        padding: 0 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-sizing: border-box;
        line-height: 1;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
    }
</style>

<div class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>Alojamientos Hoteleros</h1>
            <p class="subtitle">Explora los hoteles cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
            
            <div style="margin-top:20px;display:flex;gap:8px;">
                <a class="btn-secondary" href="{{ route('planes') }}">Atrás</a>
                <form method="POST" action="{{ route('plan.wizard.hoteles.save') }}" id="selectHotelForm" style="display:inline;">
                    @csrf
                    <div id="selected_hotels_container"></div>
                    <button type="submit" class="btn-primary">Siguiente</button>
                </form>
            </div>
        </div>

        <div id="hotels-grid" class="hotels-grid" style="margin-top:20px;">
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

                    <div class="hotel-footer">
                        <button class="btn-small btn-select-hotel" data-hotel-id="${hotel.id}">Seleccionar</button>
                    </div>
                </div>
            `;
        });

        hotelsGrid.innerHTML = html;

        // After rendering, attach click handlers to select buttons
        document.querySelectorAll('.btn-select-hotel').forEach((btn) => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                const hotelId = this.getAttribute('data-hotel-id');
                const card = this.closest('.hotel-card');
                
                // Toggle selección
                if (card.classList.contains('selected')) {
                    card.classList.remove('selected');
                    this.textContent = 'Seleccionar';
                    this.classList.remove('btn-selected');
                } else {
                    card.classList.add('selected');
                    this.textContent = '✓ Seleccionado';
                    this.classList.add('btn-selected');
                }
                
                // Actualizar inputs hidden
                updateSelectedHotels();
            });
        });
    }

    function updateSelectedHotels() {
        const selectedIds = [];
        document.querySelectorAll('.hotel-card.selected').forEach(card => {
            const btn = card.querySelector('.btn-select-hotel');
            const hotelId = btn.getAttribute('data-hotel-id');
            selectedIds.push(hotelId);
        });
        
        const container = document.getElementById('selected_hotels_container');
        container.innerHTML = '';
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'hotel_ids[]';
            input.value = id;
            container.appendChild(input);
        });
    }

    // Inicializar en carga: mostrar hoteles directamente
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar los hoteles ya filtrados por el servidor
        mostrarHoteles(todosHoteles);

        // Si hay hoteles seleccionados en draft, marcarlos
        @if(isset($draft['hotels']) && is_array($draft['hotels']) && count($draft['hotels']) > 0)
            setTimeout(() => {
                const selectedIds = {!! json_encode(array_column($draft['hotels'], 'id')) !!};
                document.querySelectorAll('.btn-select-hotel').forEach((btn) => {
                    if (selectedIds.includes(parseInt(btn.getAttribute('data-hotel-id')))) {
                        btn.click();
                    }
                });
            }, 200);
        @endif
    });
</script>

@endsection