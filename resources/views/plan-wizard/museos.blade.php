@extends('layouts.app')

@section('content')
<style>
    .museum-card.selected {
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
    
    .btn-small, .btn-select-museum {
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
            <h1>Museos</h1>
            <p class="subtitle">Explora los museos cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
            
            <div style="margin-top:20px;display:flex;gap:8px;">
                <a class="btn-secondary" href="{{ route('plan.wizard.restaurantes') }}">Atrás</a>
                <form method="POST" action="{{ route('plan.wizard.museos.save') }}" id="selectMuseumForm" style="display:inline;">
                    @csrf
                    <div id="selected_museums_container"></div>
                    <button type="submit" class="btn-primary">Siguiente</button>
                </form>
            </div>
        </div>

        <div id="museums-grid" class="hotels-grid" style="margin-top:20px;">
            @if($museums->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">No se han encontrado museos para la localidad seleccionada.</p>
                </div>
            @else
                {{-- El JS rellenará las tarjetas dinámicamente usando todosMuseos --}}
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>No se encontraron museos para la localidad seleccionada.</p>
        </div>
    </div>
</div>

<script>
    const todosMuseos = @json($museums);

    function mostrarMuseos(museos) {
        const museumsGrid = document.getElementById('museums-grid');
        const noResults = document.getElementById('no-results');
        
        if (museos.length === 0) {
            museumsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay museos disponibles para los filtros seleccionados</p></div>';
            noResults.style.display = 'none';
            return;
        }

        noResults.style.display = 'none';
        let html = '';

        museos.forEach(museo => {
            const phoneLink = museo.phone ? `<p><strong>📞 Teléfono:</strong> <a href="tel:${museo.phone}">${museo.phone}</a></p>` : '';
            const emailLink = museo.email ? `<p><strong>📧 Email:</strong> <a href="mailto:${museo.email}">${museo.email}</a></p>` : '';
            const website = museo.website ? `<p><strong>🌐 Sitio Web:</strong> <a href="${museo.website}" target="_blank">Visitar web</a></p>` : '';

            html += `
                <div class="hotel-card museum-card">
                    <div class="hotel-header">
                        <div class="hotel-title">
                            <h3>${museo.name}</h3>
                            <p class="hotel-location">📍 ${museo.locality}, ${museo.province}</p>
                        </div>
                    </div>

                    <div class="hotel-body">
                        ${museo.classification ? `<p class="hotel-classification"><strong>Tipo:</strong> ${museo.classification}</p>` : ''}
                        ${museo.address ? `<p class="hotel-address"><strong>Dirección:</strong> ${museo.address}</p>` : ''}
                        ${museo.postal_code ? `<p class="hotel-postal"><strong>Código Postal:</strong> ${museo.postal_code}</p>` : ''}

                        <div class="hotel-contact">
                            ${phoneLink}
                            ${emailLink}
                            ${website}
                        </div>

                        ${museo.description ? `<p class="hotel-description">${museo.description}</p>` : ''}
                    </div>

                    <div class="hotel-footer">
                        <button class="btn-small btn-select-museum" data-museum-id="${museo.id}">Seleccionar</button>
                    </div>
                </div>
            `;
        });

        museumsGrid.innerHTML = html;

        document.querySelectorAll('.btn-select-museum').forEach((btn) => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                const museumId = this.getAttribute('data-museum-id');
                const card = this.closest('.museum-card');
                
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
                updateSelectedMuseums();
            });
        });
    }

    function updateSelectedMuseums() {
        const selectedIds = [];
        document.querySelectorAll('.museum-card.selected').forEach(card => {
            const btn = card.querySelector('.btn-select-museum');
            const museumId = btn.getAttribute('data-museum-id');
            selectedIds.push(museumId);
        });
        
        const container = document.getElementById('selected_museums_container');
        container.innerHTML = '';
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'museo_ids[]';
            input.value = id;
            container.appendChild(input);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        mostrarMuseos(todosMuseos);

        @if(isset($draft['museos']) && is_array($draft['museos']) && count($draft['museos']) > 0)
            setTimeout(() => {
                const selectedIds = {!! json_encode(array_column($draft['museos'], 'id')) !!};
                document.querySelectorAll('.btn-select-museum').forEach((btn) => {
                    if (selectedIds.includes(parseInt(btn.getAttribute('data-museum-id')))) {
                        btn.click();
                    }
                });
            }, 100);
        @endif
    });
</script>

@endsection
