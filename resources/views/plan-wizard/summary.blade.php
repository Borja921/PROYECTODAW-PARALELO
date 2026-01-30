@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resumen de tu plan</h1>

    <div style="margin-bottom:12px;">
        <strong>Provincia:</strong> {{ $draft['provincia'] }} — <strong>Municipio:</strong> {{ $draft['municipio'] }}
        <div><strong>Fechas:</strong> {{ $draft['start_date'] }} → {{ $draft['end_date'] }}</div>
    </div>

    <div style="margin-bottom:12px;">
        <h3>Selecciones</h3>
        <ul>
            <li><strong>Hotel:</strong> {{ $draft['hotel']['name'] ?? '— (no seleccionado)' }}</li>
            <li><strong>Restaurante:</strong> {{ $draft['restaurante']['name'] ?? '— (no seleccionado)' }}</li>
            <li><strong>Museo:</strong> {{ $draft['museo']['name'] ?? '— (no seleccionado)' }}</li>
            <li><strong>Fiesta:</strong> {{ $draft['fiesta']['name'] ?? '— (no seleccionado)' }}</li>
        </ul>
    </div>

    <form method="POST" action="{{ route('plan.wizard.finalize') }}">
        @csrf
        <div style="display:flex;gap:8px;">
            <a class="btn-secondary" href="{{ route('plan.wizard.fiestas') }}">Atrás</a>
            <button type="submit" class="btn-primary">Finalizar Plan</button>
        </div>
    </form>
</div>
@endsection