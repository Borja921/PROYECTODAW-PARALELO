@extends('layouts.app')

@section('content')
<style>
    .restaurant-card.selected {
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
    
    .btn-small, .btn-select-restaurant {
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
            <h1>Restaurantes</h1>
            <p class="subtitle">Explora los restaurantes cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
            
            <div style="margin-top:20px;display:flex;gap:8px;">
                <a class="btn-secondary" href="{{ route('plan.wizard.hoteles') }}">Atrás</a>
                <form method="POST" action="{{ route('plan.wizard.restaurantes.save') }}" id="selectRestaurantForm" style="display:inline;">
                    @csrf
                    <div id="selected_restaurants_container"></div>
                    <button type="submit" class="btn-primary">Siguiente</button>
                </form>
            </div>
        </div>

        <div id="restaurants-grid" class="hotels-grid" style="margin-top:20px;">
            @if($restaurants->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">No se han encontrado restaurantes para la localidad seleccionada.</p>
                </div>
            @else
                {{-- El JS rellenará las tarjetas dinámicamente usando todosRestaurantes --}}
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>No se encontraron restaurantes para la localidad seleccionada.</p>
        </div>
    </div>
</div>

<script>
    const todosRestaurantes = @json($restaurants);

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
                <div class="hotel-card restaurant-card">
                    <div class="hotel-header">
                        <div class="hotel-title">
                            <h3>${restaurant.name}</h3>
                            <p class="hotel-location">📍 ${restaurant.locality}, ${restaurant.province}</p>
                        </div>
                    </div>

                    <div class="hotel-body">
                        ${restaurant.classification ? `<p class="hotel-classification"><strong>Tipo:</strong> ${restaurant.classification}</p>` : ''}
                        ${restaurant.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${restaurant.address}</p>` : ''}
                        ${restaurant.postal_code ? `<p class="hotel-postal"><strong>Código Postal:</strong> ${restaurant.postal_code}</p>` : ''}
                        ${restaurant.capacity ? `<p class="hotel-rooms"><strong>Capacidad:</strong> ${restaurant.capacity} personas</p>` : ''}

                        <div class="hotel-contact">
                            ${phoneLink}
                            ${emailLink}
                            ${website}
                        </div>

                        ${restaurant.description ? `<p class="hotel-description">${restaurant.description}</p>` : ''}
                    </div>

                    <div class="hotel-footer">
                        <button class="btn-small btn-select-restaurant" data-restaurant-id="${restaurant.id}">Seleccionar</button>
                    </div>
                </div>
            `;
        });

        restaurantsGrid.innerHTML = html;

        // After rendering, attach click handlers to select buttons
        document.querySelectorAll('.btn-select-restaurant').forEach((btn) => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                const restaurantId = this.getAttribute('data-restaurant-id');
                const card = this.closest('.restaurant-card');
                
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
                updateSelectedRestaurants();
            });
        });
    }

    function updateSelectedRestaurants() {
        const selectedIds = [];
        document.querySelectorAll('.restaurant-card.selected').forEach(card => {
            const btn = card.querySelector('.btn-select-restaurant');
            const restaurantId = btn.getAttribute('data-restaurant-id');
            selectedIds.push(restaurantId);
        });
        
        const container = document.getElementById('selected_restaurants_container');
        container.innerHTML = '';
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'restaurante_ids[]';
            input.value = id;
            container.appendChild(input);
        });
    }

    // Inicializar en carga: mostrar restaurantes directamente
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar los restaurantes ya filtrados por el servidor
        mostrarRestaurantes(todosRestaurantes);

        // Si hay restaurantes seleccionados en draft, marcarlos
        @if(isset($draft['restaurantes']) && is_array($draft['restaurantes']) && count($draft['restaurantes']) > 0)
            setTimeout(() => {
                const selectedIds = {!! json_encode(array_column($draft['restaurantes'], 'id')) !!};
                document.querySelectorAll('.btn-select-restaurant').forEach((btn) => {
                    if (selectedIds.includes(parseInt(btn.getAttribute('data-restaurant-id')))) {
                        btn.click();
                    }
                });
            }, 100);
        @endif
    });
</script>

@endsection