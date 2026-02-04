@extends('layouts.app')

@section('title', 'Iniciar Sesión - MateCyL')

@push('styles')
<script async defer src="https://cdn.jsdelivr.net/npm/altcha/dist/altcha.min.js" type="module"></script>
@endpush

@section('content')
<section class="auth-section">
        <div class="auth-container">
            <div class="auth-card">
                <h1>Iniciar Sesión</h1>
                <p class="auth-subtitle">Accede a tu cuenta MateCyL</p>

                @if ($errors->any())
                    <div class="alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="login">Nombre de usuario o correo</label>
                        <input id="login" name="login" type="text" required value="{{ old('login') }}" placeholder="usuario@ejemplo.com">
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" name="password" type="password" required placeholder="••••••••">
                    </div>

                    <div class="form-group checkbox">
                        <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuérdame</label>
                    </div>

                    <div class="form-group">
                        <label>Verificación</label>
                        <altcha-widget test></altcha-widget>
                    </div>

                    <button type="submit" class="btn-primary">Iniciar Sesión</button>

                    <div class="auth-footer">
                        <p>¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate aquí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
