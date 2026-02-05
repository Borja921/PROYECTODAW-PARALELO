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

    <form id="registroForm" method="POST" action="{{ route('registro.store') }}" novalidate>
        @csrf

        <div class="form-group">
            <label for="nombre_apellidos">Nombre y apellidos</label>
            <input id="nombre_apellidos" name="nombre_apellidos" class="form-control" required value="{{ old('nombre_apellidos') }}" minlength="3" maxlength="100">
            <div id="nombreError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
        </div>

        <div class="form-group">
            <label for="username">Nombre de usuario</label>
            <input id="username" name="username" class="form-control" required value="{{ old('username') }}" minlength="3" maxlength="20" pattern="[a-zA-Z0-9_-]+" title="Solo letras, números, guiones y guiones bajos">
            <div id="usernameError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" class="form-control" required value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div id="emailError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="form-control" required value="{{ old('fecha_nacimiento') }}">
            @error('fecha_nacimiento')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div id="fechaError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" class="form-control" required minlength="8">
            <small style="display: block; margin-top: 0.3rem; color: #666;">Mínimo 8 caracteres</small>
            <div id="passwordError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required minlength="8">
            <div id="passwordConfirmError" style="display:none;color:#dc3545;font-size:0.9rem;margin-top:0.3rem;"></div>
        </div>

        <div class="form-group">
            <label>Verificación</label>
            <altcha-widget test></altcha-widget>
        </div>

        <button id="registroBtn" type="submit" class="btn btn-primary">Crear Cuenta</button>
    </form>
</div>
@endsection

<script src="{{ asset('js/registro.js') }}" defer></script>
