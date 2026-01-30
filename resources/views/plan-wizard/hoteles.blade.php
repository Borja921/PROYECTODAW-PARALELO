@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Selecciona un hotel (opcional)</h1>

    <div style="margin-bottom:12px;">
        <strong>Provincia:</strong> {{ $draft['provincia'] }} — <strong>Municipio:</strong> {{ $draft['municipio'] }}
        <div><strong>Fechas:</strong> {{ $draft['start_date'] }} → {{ $draft['end_date'] }}</div>
    </div>

    @if($hotels->isEmpty())
        <p>No se han encontrado hoteles para la provincia/localidad seleccionada.</p>
    @else
        <form method="POST" action="{{ route('plan.wizard.hoteles.save') }}">
            @csrf
            <ul style="list-style:none;padding:0;">
            @foreach($hotels as $hotel)
                <li style="margin-bottom:10px;padding:8px;border:1px solid #ddd;border-radius:6px;">
                    <label>
                        <input type="radio" name="hotel_id" value="{{ $hotel->id }}">
                        <strong>{{ $hotel->name }}</strong> — {{ $hotel->address ?? $hotel->locality }}
                    </label>
                </li>
            @endforeach
            </ul>

            <div style="display:flex;gap:8px;">
                <a class="btn-secondary" href="{{ route('planes') }}">Atrás</a>
                <button type="submit" class="btn-primary">Siguiente</button>
            </div>
        </form>
    @endif
</div>
@endsection
