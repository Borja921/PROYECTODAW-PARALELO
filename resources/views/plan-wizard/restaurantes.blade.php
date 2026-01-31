@extends('layouts.app')

@section('content')
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

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Selecciona un restaurante (opcional)</h1>

    <div style="margin-bottom:12px;">
        <strong>Provincia:</strong> {{ $draft['provincia'] }} — <strong>Municipio:</strong> {{ $draft['municipio'] }}
        <div><strong>Fechas:</strong> {{ $draft['start_date'] }} → {{ $draft['end_date'] }}</div>
    </div>

    @if(isset($restaurants) && $restaurants->isEmpty())
        <p>No se han encontrado restaurantes para la provincia/localidad seleccionada.</p>
    @else
        <form method="POST" action="{{ route('plan.wizard.restaurantes.save') }}">
            @csrf
            <ul style="list-style:none;padding:0;">
            @foreach($restaurants as $r)
                <li style="margin-bottom:10px;padding:8px;border:1px solid #ddd;border-radius:6px;">
                    <label>
                        <input type="radio" name="restaurante_id" value="{{ $r->id }}" {{ (isset($draft['restaurante']) && $draft['restaurante']['id']==$r->id) ? 'checked' : '' }}>
                        <strong>{{ $r->name }}</strong> — {{ $r->address ?? $r->locality }}
                    </label>
                </li>
            @endforeach
            </ul>

            <div style="display:flex;gap:8px;">
                <a class="btn-secondary" href="{{ route('plan.wizard.hoteles') }}">Atrás</a>
                <button type="submit" class="btn-primary">Siguiente</button>
            </div>
        </form>
    @endif
</div>
@endsection
