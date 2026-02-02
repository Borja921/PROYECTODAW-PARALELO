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
                    <input type="hidden" name="restaurante_id" id="selected_restaurant_id" value="{{ $draft['restaurante']['id'] ?? '' }}">
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
                        <div class="hotel-rating">
                            ${restaurant.rating ? `<span class="rating-stars">⭐ ${restaurant.rating}/5.0</span>` : ''}
                            ${restaurant.reviews_count > 0 ? `<span class="reviews-count">(${restaurant.reviews_count} reseñas)</span>` : ''}
                        </div>
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
                
                // Limpiar selecciones previas
                document.querySelectorAll('.restaurant-card.selected').forEach(c => {
                    c.classList.remove('selected');
                    c.querySelector('.btn-select-restaurant').textContent = 'Seleccionar';
                    c.querySelector('.btn-select-restaurant').classList.remove('btn-selected');
                });
                
                // Marcar como seleccionado
                card.classList.add('selected');
                this.textContent = '✓ Seleccionado';
                this.classList.add('btn-selected');
                
                // Guardar ID en el input hidden
                document.getElementById('selected_restaurant_id').value = restaurantId;
            });
        });
    }

    // Inicializar en carga: mostrar restaurantes directamente
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar los restaurantes ya filtrados por el servidor
        mostrarRestaurantes(todosRestaurantes);

        // Si hay restaurante seleccionado en draft, marcarlo
        @if(isset($draft['restaurante']) && $draft['restaurante']['id'])
            setTimeout(() => {
                const id = {{ $draft['restaurante']['id'] }};
                document.querySelectorAll('.btn-select-restaurant').forEach((btn) => {
                    if (btn.getAttribute('data-restaurant-id') == id) {
                        btn.click();
                    }
                });
            }, 100);
        @endif
    });
</script>

@endsection