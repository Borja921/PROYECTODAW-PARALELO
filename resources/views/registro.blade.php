@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registro</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="registroForm" method="POST" action="{{ route('registro.store') }}">
        @csrf

        <div class="form-group">
            <label for="nombre_apellidos">Nombre y apellidos</label>
            <input id="nombre_apellidos" name="nombre_apellidos" class="form-control" required value="{{ old('nombre_apellidos') }}">
        </div>

        <div class="form-group">
            <label for="username">Nombre de usuario</label>
            <input id="username" name="username" class="form-control" required value="{{ old('username') }}">
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" class="form-control" required value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div id="emailError" style="display:none;color:#dc3545;font-size:0.9rem;"></div>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="form-control" required value="{{ old('fecha_nacimiento') }}">
            @error('fecha_nacimiento')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div id="fechaError" style="display:none;color:#dc3545;font-size:0.9rem;"></div>
        </div>

        <h3>Preferencias de viaje</h3>
        <div class="form-group">
            <label for="hospedaje_favorito">Hospedaje favorito</label>
            <select id="hospedaje_favorito" name="hospedaje_favorito" class="form-control">
                <option value="">Selecciona una opción</option>
                <option value="hotel" {{ old('hospedaje_favorito') === 'hotel' ? 'selected' : '' }}>Hotel</option>
                <option value="apartamento" {{ old('hospedaje_favorito') === 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                <option value="hostal" {{ old('hospedaje_favorito') === 'hostal' ? 'selected' : '' }}>Hostal</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_comida">Tipo de comida</label>
            <select id="tipo_comida" name="tipo_comida" class="form-control">
                <option value="">Selecciona una opción</option>
                <option value="tradicional" {{ old('tipo_comida') === 'tradicional' ? 'selected' : '' }}>Tradicional</option>
                <option value="internacional" {{ old('tipo_comida') === 'internacional' ? 'selected' : '' }}>Internacional</option>
                <option value="vegetariana" {{ old('tipo_comida') === 'vegetariana' ? 'selected' : '' }}>Vegetariana</option>
            </select>
        </div>

        <div class="form-group">
            <label for="actividades">Actividades</label>
            <select id="actividades" name="actividades" class="form-control">
                <option value="">Selecciona una opción</option>
                <option value="museos" {{ old('actividades') === 'museos' ? 'selected' : '' }}>Museos</option>
                <option value="naturaleza" {{ old('actividades') === 'naturaleza' ? 'selected' : '' }}>Naturaleza</option>
                <option value="aventura" {{ old('actividades') === 'aventura' ? 'selected' : '' }}>Aventura</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_viaje">Tipo de viaje</label>
            <select id="tipo_viaje" name="tipo_viaje" class="form-control">
                <option value="">Selecciona una opción</option>
                <option value="pareja" {{ old('tipo_viaje') === 'pareja' ? 'selected' : '' }}>En pareja</option>
                <option value="familia" {{ old('tipo_viaje') === 'familia' ? 'selected' : '' }}>En familia</option>
                <option value="amigos" {{ old('tipo_viaje') === 'amigos' ? 'selected' : '' }}>Con amigos</option>
            </select>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Verificación</label>
            <altcha-widget test></altcha-widget>
        </div>

        <button type="submit" class="btn btn-primary">Crear Cuenta</button>
    </form>
</div>
@endsection

<script src="{{ asset('js/registro.js') }}" defer></script>
