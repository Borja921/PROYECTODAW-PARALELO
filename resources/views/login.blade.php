<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <section class="auth-section">
        <div class="auth-container">
            <div class="auth-card">
                <h1>Iniciar Sesión</h1>
                <p class="auth-subtitle">Accede a tu cuenta TravelPlus</p>

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

                    <button type="submit" class="btn-primary">Iniciar Sesión</button>

                    <div class="auth-footer">
                        <p>¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate aquí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
