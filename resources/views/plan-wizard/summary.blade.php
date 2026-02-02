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
</style>

<div class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>Resumen de tu plan</h1>
            <p class="subtitle">Revisa tus selecciones antes de finalizar</p>

            @if(session('success'))
                <div class="alert alert-success" style="margin: 12px 0; padding: 10px; border-radius: 6px; background: #d4edda; color: #155724;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="margin-top:20px;display:flex;gap:8px;flex-wrap:wrap;">
                <form method="POST" action="{{ route('plan.wizard.finalize') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-primary">Guardar Plan</button>
                </form>
                <a class="btn-secondary" href="{{ route('planes') }}">Crear otro plan</a>
            </div>
        </div>

        <div class="summary-card" style="margin-top:20px;">
            <div class="summary-header">
                <div class="summary-title">🧭 Resumen visual de tu viaje</div>
                <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                    <span class="summary-chip">📍 {{ $draft['provincia'] }} · {{ $draft['municipio'] }}</span>
                    <span class="summary-chip">📅 {{ $draft['start_date'] }} → {{ $draft['end_date'] }}</span>
                </div>
            </div>

            <div class="summary-grid">
                <div class="summary-item">
                    <span class="item-icon">🏨</span>
                    <strong>Hotel</strong>
                    <div class="item-name">{{ $draft['hotel']['name'] ?? 'Sin selección' }}</div>
                    <div class="item-sub">Tu descanso con estilo</div>
                    @if(empty($draft['hotel']['name']))
                        <span class="badge-empty">No seleccionado</span>
                    @endif
                </div>
                <div class="summary-item">
                    <span class="item-icon">🍽️</span>
                    <strong>Restaurante</strong>
                    <div class="item-name">{{ $draft['restaurante']['name'] ?? 'Sin selección' }}</div>
                    <div class="item-sub">Sabores locales para ti</div>
                    @if(empty($draft['restaurante']['name']))
                        <span class="badge-empty">No seleccionado</span>
                    @endif
                </div>
                <div class="summary-item">
                    <span class="item-icon">🎨</span>
                    <strong>Museo</strong>
                    <div class="item-name">{{ $draft['museo']['name'] ?? 'Sin selección' }}</div>
                    <div class="item-sub">Cultura y patrimonio</div>
                    @if(empty($draft['museo']['name']))
                        <span class="badge-empty">No seleccionado</span>
                    @endif
                </div>
                <div class="summary-item">
                    <span class="item-icon">🎉</span>
                    <strong>Fiesta</strong>
                    <div class="item-name">{{ $draft['fiesta']['name'] ?? 'Sin selección' }}</div>
                    <div class="item-sub">Tradición y alegría</div>
                    @if(empty($draft['fiesta']['name']))
                        <span class="badge-empty">No seleccionado</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
