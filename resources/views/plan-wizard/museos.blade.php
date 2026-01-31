@extends('layouts.app')

@section('content')
<style>
    .btn-quitar-museo {
        background: #e74c3c !important;
        color: #fff !important;
        border: none;
    }
</style>
<div class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>Museos</h1>
            <p class="subtitle">Explora los museos cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
        </div>

        <div class="hotels-filters">
            <div class="filter-group" style="width:100%;display:flex;flex-direction:column;align-items:center;gap:8px;">
                <a href="/plan/wizard/restaurantes" class="btn-primary" style="width:auto;">Seleccionar restaurantes</a>
                <a class="btn-secondary" href="{{ route('plan.wizard.hoteles') }}" style="width:auto;">Atrás</a>
            </div>
        </div>

        <div id="museos-grid" class="hotels-grid">
            @if($museums->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">No se han encontrado museos para la localidad seleccionada.</p>
                </div>
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>No se encontraron museos para la localidad seleccionada.</p>
        </div>

        <div style="margin-top:16px;display:flex;gap:8px;">
            <!-- Botones de navegación eliminados -->
        </div>
    </div>
</div>

<script>
    const todosMuseos = @json($museums);

    function mostrarMuseos(museos) {
        const museosGrid = document.getElementById('museos-grid');
        const noResults = document.getElementById('no-results');
        if (museos.length === 0) {
            museosGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay museos disponibles</p></div>';
            noResults.style.display = 'none';
            return;
        }
        noResults.style.display = 'none';
        let html = '';
        museos.forEach(museo => {
            html += `
                <div class="hotel-card">
                    <div class="hotel-header">
                        <div class="hotel-title">
                            <h3>${museo.name}</h3>
                            <p class="hotel-location">📍 ${museo.locality ?? ''}, ${museo.province ?? ''}</p>
                        </div>
                    </div>
                    <div class="hotel-body">
                        ${museo.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${museo.address}</p>` : ''}
                        ${museo.description ? `<p class="hotel-description">${museo.description}</p>` : ''}
                    </div>
                    <div class="hotel-footer">
                        <button class="btn-small btn-guardar-museo" data-museo-id="${museo.id}">Guardar</button>
                    </div>
                </div>
            `;
        });
        museosGrid.innerHTML = html;
        document.querySelectorAll('.hotel-card').forEach((card, idx) => {
            card.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-guardar-museo')) return;
                document.querySelectorAll('.hotel-card.selected').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                const museoId = todosMuseos[idx].id;
                document.getElementById('selected_museo_id').value = museoId;
            });
        });
        document.querySelectorAll('.btn-guardar-museo').forEach((btn, idx) => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (btn.textContent === 'Guardar') {
                    btn.textContent = 'Quitar';
                    btn.classList.add('btn-quitar-museo');
                } else {
                    btn.textContent = 'Guardar';
                    btn.classList.remove('btn-quitar-museo');
                }
            });
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        mostrarMuseos(todosMuseos);
        @if(isset($draft['museo']) && $draft['museo']['id'])
            setTimeout(() => {
                const id = '{{ $draft['museo']['id'] }}';
                document.querySelectorAll('.hotel-card').forEach(card => {
                    if (card.innerHTML.includes(id)) {
                        card.classList.add('selected');
                        document.getElementById('selected_museo_id').value = id;
                    }
                });
            }, 50);
        @endif
    });
</script>

@endsection
