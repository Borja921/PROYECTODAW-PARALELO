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
