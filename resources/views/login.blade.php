@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Iniciar sesión</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label for="login">Nombre de usuario o correo</label>
            <input id="login" name="login" class="form-control" required value="{{ old('login') }}">
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a></p>
</div>
@endsection
