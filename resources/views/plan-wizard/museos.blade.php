@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Selecciona un museo (opcional)</h1>

    <div style="margin-bottom:12px;">
        <strong>Provincia:</strong> {{ $draft['provincia'] }} — <strong>Municipio:</strong> {{ $draft['municipio'] }}
        <div><strong>Fechas:</strong> {{ $draft['start_date'] }} → {{ $draft['end_date'] }}</div>
    </div>

    @if(isset($museums) && $museums->isEmpty())
        <p>No se han encontrado museos para la provincia/localidad seleccionada.</p>
    @else
        <form method="POST" action="{{ route('plan.wizard.museos.save') }}">
            @csrf
            <ul style="list-style:none;padding:0;">
            @foreach($museums as $m)
                <li style="margin-bottom:10px;padding:8px;border:1px solid #ddd;border-radius:6px;">
                    <label>
                        <input type="radio" name="museo_id" value="{{ $m->id }}" {{ (isset($draft['museo']) && $draft['museo']['id']==$m->id) ? 'checked' : '' }}>
                        <strong>{{ $m->name }}</strong> — {{ $m->address ?? $m->locality }}
                    </label>
                </li>
            @endforeach
            </ul>

            <div style="display:flex;gap:8px;">
                <a class="btn-secondary" href="{{ route('plan.wizard.restaurantes') }}">Atrás</a>
                <button type="submit" class="btn-primary">Siguiente</button>
            </div>
        </form>
    @endif
</div>
@endsection