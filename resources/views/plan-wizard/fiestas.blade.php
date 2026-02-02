@extends('layouts.app')

@section('content')
<style>
    .festival-card.selected {
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
    
    .btn-small, .btn-select-festival {
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
            <h1>Fiestas</h1>
            <p class="subtitle">Explora las fiestas cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
            
            <div style="margin-top:20px;display:flex;gap:8px;">
                <a class="btn-secondary" href="{{ route('plan.wizard.museos') }}">Atrás</a>
                <form method="POST" action="{{ route('plan.wizard.fiestas.save') }}" id="selectFestivalForm" style="display:inline;">
                    @csrf
                    <div id="selected_festivals_container"></div>
                    <button type="submit" class="btn-primary">Siguiente</button>
                </form>
            </div>
        </div>

        <div id="festivals-grid" class="hotels-grid" style="margin-top:20px;">
            @if($festivals->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">No se han encontrado fiestas para la localidad seleccionada.</p>
                </div>
            @else
                {{-- El JS rellenará las tarjetas dinámicamente usando todosFiestas --}}
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>No se encontraron fiestas para la localidad seleccionada.</p>
        </div>
    </div>
</div>

<script>
    const todasFiestas = @json($festivals);

    function mostrarFiestas(fiestas) {
        const festivalsGrid = document.getElementById('festivals-grid');
        const noResults = document.getElementById('no-results');
        
        if (fiestas.length === 0) {
            festivalsGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay fiestas disponibles para los filtros seleccionados</p></div>';
            noResults.style.display = 'none';
            return;
        }

        noResults.style.display = 'none';
        let html = '';

        fiestas.forEach(fiesta => {
            const startDate = fiesta.start_date ? new Date(fiesta.start_date).toISOString().slice(0, 10) : '';
            const endDate = fiesta.end_date ? new Date(fiesta.end_date).toISOString().slice(0, 10) : '';
            const dateRange = startDate && endDate ? `${startDate} → ${endDate}` : (startDate || endDate);

            html += `
                <div class="hotel-card festival-card">
                    <div class="hotel-header">
                        <div class="hotel-title">
                            <h3>${fiesta.name}</h3>
                            <p class="hotel-location">📍 ${fiesta.locality}, ${fiesta.province}</p>
                        </div>
                    </div>

                    <div class="hotel-body">
                        ${dateRange ? `<p class="hotel-classification"><strong>Fechas:</strong> ${dateRange}</p>` : ''}
                        ${fiesta.description ? `<p class="hotel-description">${fiesta.description}</p>` : ''}
                        ${fiesta.category ? `<p class="hotel-classification"><strong>Categoría:</strong> ${fiesta.category}</p>` : ''}
                    </div>

                    <div class="hotel-footer">
                        <button class="btn-small btn-select-festival" data-festival-id="${fiesta.id}">Seleccionar</button>
                    </div>
                </div>
            `;
        });

        festivalsGrid.innerHTML = html;

        document.querySelectorAll('.btn-select-festival').forEach((btn) => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                const festivalId = this.getAttribute('data-festival-id');
                const card = this.closest('.festival-card');
                
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
                updateSelectedFestivals();
            });
        });
    }

    function updateSelectedFestivals() {
        const selectedIds = [];
        document.querySelectorAll('.festival-card.selected').forEach(card => {
            const btn = card.querySelector('.btn-select-festival');
            const festivalId = btn.getAttribute('data-festival-id');
            selectedIds.push(festivalId);
        });
        
        const container = document.getElementById('selected_festivals_container');
        container.innerHTML = '';
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'fiesta_ids[]';
            input.value = id;
            container.appendChild(input);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        mostrarFiestas(todasFiestas);

        @if(isset($draft['fiestas']) && is_array($draft['fiestas']) && count($draft['fiestas']) > 0)
            setTimeout(() => {
                const selectedIds = {!! json_encode(array_column($draft['fiestas'], 'id')) !!};
                document.querySelectorAll('.btn-select-festival').forEach((btn) => {
                    if (selectedIds.includes(parseInt(btn.getAttribute('data-festival-id')))) {
                        btn.click();
                    }
                });
            }, 100);
        @endif
    });
</script>

@endsection