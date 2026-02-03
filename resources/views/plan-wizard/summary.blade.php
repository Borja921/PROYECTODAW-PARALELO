@extends('layouts.app')

@section('content')
<style>
    .summary-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9f6f2 100%);
        border: 1px solid #e7e1db;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.10);
        position: relative;
        overflow: hidden;
    }

    .summary-card::before {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 160px;
        height: 160px;
        background: radial-gradient(circle, rgba(139, 123, 123, 0.18) 0%, rgba(139, 123, 123, 0) 70%);
        pointer-events: none;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .summary-item {
        background: #ffffff;
        border: 1px solid #eee6de;
        border-radius: 14px;
        padding: 14px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .summary-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.10);
    }

    .summary-item strong {
        display: block;
        color: #333;
        margin-bottom: 6px;
    }

    .summary-header {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        background: linear-gradient(135deg, rgba(139, 123, 123, 0.12), rgba(192, 181, 170, 0.12));
        border: 1px solid #f0e3d9;
        border-radius: 16px;
        padding: 16px;
    }

    .summary-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #4b3f37;
        font-size: 1.05rem;
    }

    .summary-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #eddccf;
        font-weight: 600;
        color: #5b4f48;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
    }

    .summary-grid .summary-item {
        position: relative;
    }

    .summary-item .item-icon {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 1.3rem;
        opacity: 0.7;
    }

    .summary-item .item-name {
        font-size: 1.05rem;
        font-weight: 600;
        color: #2f2a26;
        margin-top: 2px;
    }

    .summary-item .item-sub {
        color: #7a6f66;
        font-size: 0.9rem;
        margin-top: 6px;
    }

    .badge-empty {
        display: inline-block;
        background: #fff1f1;
        color: #b15a5a;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 999px;
        border: 1px dashed #e7b3b3;
        margin-top: 6px;
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

    .btn-remove {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        font-size: 18px;
        padding: 4px 8px;
        transition: color 0.2s ease;
    }

    .btn-remove:hover {
        color: #c82333;
    }

    .item-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8f6f3;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        border-left: 3px solid #8b7b7b;
    }

    .plan-name-section {
        background: linear-gradient(135deg, #f9f6f2 0%, #ffffff 100%);
        border: 1px solid #e7e1db;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .plan-name-section label {
        display: block;
        font-weight: 600;
        color: #4b3f37;
        margin-bottom: 8px;
    }

    .plan-name-section input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #eddccf;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        box-sizing: border-box;
    }

    .plan-name-section input:focus {
        outline: none;
        border-color: #8b7b7b;
        box-shadow: 0 0 0 3px rgba(139, 123, 123, 0.1);
    }
</style>

<div class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>Resumen de tu plan</h1>
            <p class="subtitle">Revisa tus selecciones antes de finalizar</p>

            @if(session('success'))
                <div class="alert alert-success" style="margin: 12px 0; padding: 10px; border-radius: 6px; background: #d4edda; color: #155724;">
                    {{ session('success') }}
                    <div style="margin-top:12px;">
                        <a href="{{ route('plan.wizard.clear') }}" class="btn-primary">Confirmar y continuar</a>
                    </div>
                </div>
            @endif

            <div style="margin-top:20px;display:flex;gap:8px;flex-wrap:wrap;">
                <form method="POST" action="{{ route('plan.wizard.finalize') }}" style="display:inline;" id="finalizeForm">
                    @csrf
                    <input type="hidden" name="plan_name" id="plan_name_input" value="{{ $draft['plan_name'] ?? '' }}">
                    <button type="submit" class="btn-primary">Guardar Plan</button>
                </form>
                <form method="POST" action="{{ route('plan.wizard.reset') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-secondary">Crear otro plan</button>
                </form>
            </div>
        </div>

        <div class="summary-card" style="margin-top:20px;">
            <div class="plan-name-section">
                <label for="plan_name">Nombre de tu plan</label>
                <input type="text" id="plan_name" placeholder="Ej: Fin de semana en Granada" value="{{ $draft['plan_name'] ?? '' }}" onchange="updatePlanName(this.value)">
            </div>

            <div class="summary-header">
                <div class="summary-title">🧭 Resumen visual de tu viaje</div>
                <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                    <span class="summary-chip">📍 {{ $draft['provincia'] }} · {{ $draft['municipio'] }}</span>
                    <span class="summary-chip">📅 {{ $draft['start_date'] }} → {{ $draft['end_date'] }}</span>
                </div>
            </div>

            <div class="summary-grid">
                <!-- HOTELES -->
                <div class="summary-item" style="grid-column: 1/-1;">
                    <span class="item-icon">🏨</span>
                    <strong>Hoteles Seleccionados</strong>
                    @if(isset($draft['hotels']) && count($draft['hotels']) > 0)
                        <div style="margin-top: 12px;">
                            @foreach($draft['hotels'] as $index => $hotel)
                                <div class="item-container">
                                    <div class="item-name" style="margin-top: 0; flex-grow: 1;">{{ $hotel['name'] }}</div>
                                    <button type="button" class="btn-remove" onclick="removeItem('hotels', {{ $index }})">✕</button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="badge-empty">No seleccionados</span>
                    @endif
                </div>

                <!-- RESTAURANTES -->
                <div class="summary-item" style="grid-column: 1/-1;">
                    <span class="item-icon">🍽️</span>
                    <strong>Restaurantes Seleccionados</strong>
                    @if(isset($draft['restaurantes']) && count($draft['restaurantes']) > 0)
                        <div style="margin-top: 12px;">
                            @foreach($draft['restaurantes'] as $index => $restaurante)
                                <div class="item-container">
                                    <div class="item-name" style="margin-top: 0; flex-grow: 1;">{{ $restaurante['name'] }}</div>
                                    <button type="button" class="btn-remove" onclick="removeItem('restaurantes', {{ $index }})">✕</button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="badge-empty">No seleccionados</span>
                    @endif
                </div>

                <!-- MUSEOS -->
                <div class="summary-item" style="grid-column: 1/-1;">
                    <span class="item-icon">🎨</span>
                    <strong>Museos Seleccionados</strong>
                    @if(isset($draft['museos']) && count($draft['museos']) > 0)
                        <div style="margin-top: 12px;">
                            @foreach($draft['museos'] as $index => $museo)
                                <div class="item-container">
                                    <div class="item-name" style="margin-top: 0; flex-grow: 1;">{{ $museo['name'] }}</div>
                                    <button type="button" class="btn-remove" onclick="removeItem('museos', {{ $index }})">✕</button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="badge-empty">No seleccionados</span>
                    @endif
                </div>

                <!-- FIESTAS -->
                <div class="summary-item" style="grid-column: 1/-1;">
                    <span class="item-icon">🎉</span>
                    <strong>Fiestas Seleccionadas</strong>
                    @if(isset($draft['fiestas']) && count($draft['fiestas']) > 0)
                        <div style="margin-top: 12px;">
                            @foreach($draft['fiestas'] as $index => $fiesta)
                                <div class="item-container">
                                    <div>
                                        <div class="item-name" style="margin-top: 0;">{{ $fiesta['name'] }}</div>
                                        @if(isset($fiesta['date']))
                                            <div class="item-sub" style="margin-top: 4px;">{{ \Carbon\Carbon::parse($fiesta['date'])->format('d/m/Y') }}</div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn-remove" onclick="removeItem('fiestas', {{ $index }})">✕</button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="badge-empty">No seleccionadas</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function removeItem(category, index) {
        // Crear formulario temporal para enviar al servidor
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("plan.wizard.remove-item") }}';
        form.style.display = 'none';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const categoryInput = document.createElement('input');
        categoryInput.type = 'hidden';
        categoryInput.name = 'category';
        categoryInput.value = category;
        
        const indexInput = document.createElement('input');
        indexInput.type = 'hidden';
        indexInput.name = 'index';
        indexInput.value = index;
        
        form.appendChild(csrfInput);
        form.appendChild(categoryInput);
        form.appendChild(indexInput);
        document.body.appendChild(form);
        form.submit();
    }

    function updatePlanName(name) {
        document.getElementById('plan_name_input').value = name;
    }
</script>
@endsection
