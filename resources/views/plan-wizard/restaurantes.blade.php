@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Selecciona un restaurante (opcional)</h1>

    <p>En la siguiente iteración mostraremos restaurantes filtrados por <strong>{{ $draft['provincia'] }}</strong> / <strong>{{ $draft['municipio'] }}</strong>.</p>

    <div style="display:flex;gap:8px;">
        <a class="btn-secondary" href="{{ route('plan.wizard.hoteles') }}">Atrás</a>
        <a class="btn-primary" href="{{ route('plan.wizard.hoteles') }}">Siguiente (próximamente)</a>
    </div>
</div>
@endsection
