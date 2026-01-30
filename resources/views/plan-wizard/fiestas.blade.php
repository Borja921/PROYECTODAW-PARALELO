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