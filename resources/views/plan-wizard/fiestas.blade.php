@extends('layouts.app')

@section('content')
<style>
    .btn-quitar-fiesta {
        background: #e74c3c !important;
        color: #fff !important;
        border: none;
    }
</style>
<div class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>Fiestas Locales</h1>
            <p class="subtitle">Explora las fiestas cerca de {{ $draft['municipio'] }}, {{ $draft['provincia'] }}</p>
        </div>

        <div class="hotels-filters">
            <div class="filter-group" style="width:100%;display:flex;flex-direction:column;align-items:center;gap:8px;">
                <a href="/plan/wizard/summary" class="btn-primary" style="width:auto;">Ver sumario</a>
                <a class="btn-secondary" href="{{ route('plan.wizard.restaurantes') }}" style="width:auto;">Atrás</a>
            </div>
        </div>

        <div id="fiestas-grid" class="hotels-grid">
            @if($festivals->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">No se han encontrado fiestas para la localidad seleccionada.</p>
                </div>
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>No se encontraron fiestas para la localidad seleccionada.</p>
        </div>

        <div style="margin-top:16px;display:flex;gap:8px;">
            <!-- Botones de navegación eliminados -->
        </div>
    </div>
</div>

<script>
    const todasFiestas = @json($festivals);

    function mostrarFiestas(fiestas) {
        const fiestasGrid = document.getElementById('fiestas-grid');
        const noResults = document.getElementById('no-results');
        if (fiestas.length === 0) {
            fiestasGrid.innerHTML = '<div class="placeholder-container"><p class="placeholder-text">No hay fiestas disponibles</p></div>';
            noResults.style.display = 'none';
            return;
        }
        noResults.style.display = 'none';
        let html = '';
        fiestas.forEach(fiesta => {
            html += `
                <div class="hotel-card">
                    <div class="hotel-header">
                        <div class="hotel-title">
                            <h3>${fiesta.name}</h3>
                            <p class="hotel-location">📍 ${fiesta.locality ?? ''}, ${fiesta.province ?? ''}</p>
                        </div>
                    </div>
                    <div class="hotel-body">
                        ${fiesta.start_date ? `<p><strong>Fecha:</strong> ${fiesta.start_date}</p>` : ''}
                        ${fiesta.description ? `<p class="hotel-description">${fiesta.description}</p>` : ''}
                    </div>
                    <div class="hotel-footer">
                        <button class="btn-small btn-guardar-fiesta" data-fiesta-id="${fiesta.id}">Guardar</button>
                    </div>
                </div>
            `;
        });
        fiestasGrid.innerHTML = html;
        document.querySelectorAll('.hotel-card').forEach((card, idx) => {
            card.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-guardar-fiesta')) return;
                document.querySelectorAll('.hotel-card.selected').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                const fiestaId = todasFiestas[idx].id;
                document.getElementById('selected_fiesta_id').value = fiestaId;
            });
        });
        document.querySelectorAll('.btn-guardar-fiesta').forEach((btn, idx) => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (btn.textContent === 'Guardar') {
                    btn.textContent = 'Quitar';
                    btn.classList.add('btn-quitar-fiesta');
                } else {
                    btn.textContent = 'Guardar';
                    btn.classList.remove('btn-quitar-fiesta');
                }
            });
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        mostrarFiestas(todasFiestas);
        @if(isset($draft['fiesta']) && $draft['fiesta']['id'])
            setTimeout(() => {
                const id = '{{ $draft['fiesta']['id'] }}';
                document.querySelectorAll('.hotel-card').forEach(card => {
                    if (card.innerHTML.includes(id)) {
                        card.classList.add('selected');
                        document.getElementById('selected_fiesta_id').value = id;
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
    <h1>Selecciona una fiesta (opcional)</h1>

    <div style="margin-bottom:12px;">
        <strong>Provincia:</strong> {{ $draft['provincia'] }} — <strong>Municipio:</strong> {{ $draft['municipio'] }}
        <div><strong>Fechas:</strong> {{ $draft['start_date'] }} → {{ $draft['end_date'] }}</div>
    </div>

    @if(isset($festivals) && $festivals->isEmpty())
        <p>No se han encontrado fiestas para la provincia/localidad seleccionada.</p>
    @else
        <form method="POST" action="{{ route('plan.wizard.fiestas.save') }}">
            @csrf
            <ul style="list-style:none;padding:0;">
            @foreach($festivals as $f)
                <li style="margin-bottom:10px;padding:8px;border:1px solid #ddd;border-radius:6px;">
                    <label>
                        <input type="radio" name="fiesta_id" value="{{ $f->id }}" {{ (isset($draft['fiesta']) && $draft['fiesta']['id']==$f->id) ? 'checked' : '' }}>
                        <strong>{{ $f->name }}</strong> — {{ $f->start_date ? (\Carbon\Carbon::parse($f->start_date)->format('Y-m-d')) : '' }}
                    </label>
                </li>
            @endforeach
            </ul>

            <div style="display:flex;gap:8px;">
                <a class="btn-secondary" href="{{ route('plan.wizard.museos') }}">Atrás</a>
                <button type="submit" class="btn-primary">Siguiente</button>
            </div>
        </form>
    @endif
</div>
@endsection
