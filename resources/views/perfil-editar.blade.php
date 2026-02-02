<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                @auth
                    <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                    <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                    <li><a href="{{ route('perfil') }}" class="active">Perfil</a></li>
                    <li><a href="{{ route('perfil') }}">Hola, {{ Auth::user()->nombre_apellidos }}</a></li>
                @else
                    <li><a href="#" onclick="openLoginModal(event)">Crear Plan</a></li>
                    <li><a href="#" onclick="openLoginModal(event)">Mis Planes</a></li>
                    <li><a href="#" onclick="openLoginModal(event)">Perfil</a></li>
                    <li><a href="#" onclick="openLoginModal(event)">Iniciar Sesión</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <section class="profile-section">
        <div class="profile-container">
            <div class="profile-header">
                <div>
                    <h1>Editar Perfil</h1>
                    <p class="profile-email">Actualiza tu información personal</p>
                </div>
                <a class="btn-secondary" href="{{ route('perfil') }}">← Volver</a>
            </div>

            <div class="profile-content">
                <div class="profile-section-box">
                    <h2>Información Personal</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger" style="margin-bottom: 1rem; padding: 1rem; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 6px; color: #721c24;">
                            <ul style="margin: 0; padding-left: 1.5rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('perfil.update') }}" class="edit-profile-form">
                        @csrf

                        <div class="form-group">
                            <label for="nombre_apellidos">Nombre Completo</label>
                            <input 
                                id="nombre_apellidos" 
                                name="nombre_apellidos" 
                                type="text" 
                                required 
                                value="{{ old('nombre_apellidos', $user->nombre_apellidos) }}"
                                placeholder="Juan García López"
                            >
                            @error('nombre_apellidos')
                                <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                value="{{ old('email', $user->email) }}"
                                placeholder="juan@ejemplo.com"
                            >
                            @error('email')
                                <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input 
                                id="fecha_nacimiento" 
                                name="fecha_nacimiento" 
                                type="date" 
                                value="{{ old('fecha_nacimiento', $user->fecha_nacimiento) }}"
                            >
                            @error('fecha_nacimiento')
                                <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                            <h3 style="margin-bottom: 1rem;">Cambiar Contraseña</h3>
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">Deja estos campos vacíos si no deseas cambiar tu contraseña</p>

                            <div class="form-group">
                                <label for="password">Nueva Contraseña</label>
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    placeholder="••••••••"
                                >
                                @error('password')
                                    <span class="text-danger" style="color: #721c24; font-size: 0.875rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    type="password" 
                                    placeholder="••••••••"
                                >
                            </div>
                        </div>

                        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                            <button type="submit" class="btn-primary">Guardar Cambios</button>
                            <a href="{{ route('perfil') }}" class="btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
