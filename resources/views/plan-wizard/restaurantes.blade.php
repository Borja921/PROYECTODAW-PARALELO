<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurantes - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                <li><a href="{{ route('planes') }}" class="active">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
            </ul>
        </div>
    </nav>

<style>
    .btn-quitar-restaurante {
        background: #e74c3c !important;
        color: #fff !important;
        border: none;
    }
</style>
<div class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>Restaurantes</h1>
            <p class="subtitle">Explora los restaurantes cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
        </div>

        <div class="hotels-filters">
            <div class="filter-group" style="width:100%;display:flex;flex-direction:column;align-items:center;gap:8px;">
                <a href="/plan/wizard/fiestas" class="btn-primary" style="width:auto;">Seleccionar eventos y fiestas</a>
                <a class="btn-secondary" href="{{ route('plan.wizard.museos') }}" style="width:auto;">Atrás</a>
            </div>
        </div>

        <div id="restaurantes-grid" class="hotels-grid">
            @if($restaurants->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">No se han encontrado restaurantes para la localidad seleccionada.</p>
                </div>
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>No se encontraron restaurantes para la localidad seleccionada.</p>
        </div>

        <div style="margin-top:16px;display:flex;gap:8px;">
            <!-- Botones de navegación eliminados -->
        </div>
    </div>
</div>

<script>
    const todosRestaurantes = @json($restaurants);

    function mostrarRestaurantes(restaurantes) {
        const restaurantesGrid = document.getElementById('restaurantes-grid');
        const noResults = document.getElementById('no-results');
        if (restaurantes.length === 0) {
            restaurantesGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay restaurantes disponibles</p></div>';
            noResults.style.display = 'none';
            return;
        }
        noResults.style.display = 'none';
        let html = '';
        restaurantes.forEach(restaurante => {
            html += `
                <div class="hotel-card">
                    <div class="hotel-header">
                        <div class="hotel-title">
                            <h3>${restaurante.name}</h3>
                            <p class="hotel-location">📍 ${restaurante.locality ?? ''}, ${restaurante.province ?? ''}</p>
                        </div>
                    </div>
                    <div class="hotel-body">
                        ${restaurante.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${restaurante.address}</p>` : ''}
                        ${restaurante.description ? `<p class="hotel-description">${restaurante.description}</p>` : ''}
                    </div>
                    <div class="hotel-footer">
                        <button class="btn-small btn-guardar-restaurante" data-restaurante-id="${restaurante.id}">Guardar</button>
                    </div>
                </div>
            `;
        });
        restaurantesGrid.innerHTML = html;
        document.querySelectorAll('.hotel-card').forEach((card, idx) => {
            card.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-guardar-restaurante')) return;
                document.querySelectorAll('.hotel-card.selected').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                const restauranteId = todosRestaurantes[idx].id;
                document.getElementById('selected_restaurante_id').value = restauranteId;
            });
        });
        document.querySelectorAll('.btn-guardar-restaurante').forEach((btn, idx) => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (btn.textContent === 'Guardar') {
                    btn.textContent = 'Quitar';
                    btn.classList.add('btn-quitar-restaurante');
                } else {
                    btn.textContent = 'Guardar';
                    btn.classList.remove('btn-quitar-restaurante');
                }
            });
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        mostrarRestaurantes(todosRestaurantes);
        @if(isset($draft['restaurante']) && $draft['restaurante']['id'])
            setTimeout(() => {
                const id = '{{ $draft['restaurante']['id'] }}';
                document.querySelectorAll('.hotel-card').forEach(card => {
                    if (card.innerHTML.includes(id)) {
                        card.classList.add('selected');
                        document.getElementById('selected_restaurante_id').value = id;
                    }
                });
            }, 50);
        @endif
    });
</script>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
