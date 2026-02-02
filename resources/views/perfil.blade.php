<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - TravelPlus</title>
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

    <!-- Modal de Login -->
    @guest
    <div id="loginModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" onclick="closeLoginModal()">&times;</button>
            
            <!-- Tabs -->
            <div class="auth-tabs">
                <button class="auth-tab active" onclick="switchTab('login')">Iniciar Sesión</button>
                <button class="auth-tab" onclick="switchTab('registro')">Registrarse</button>
            </div>

            <!-- Formulario de Login -->
            <div id="loginForm" class="auth-tab-content active">
                <h2>Bienvenido</h2>
                <p class="auth-subtitle">Accede a tu cuenta TravelPlus</p>

                @if ($errors->any())
                    <div class="alert">
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
                </form>
            </div>

            <!-- Formulario de Registro -->
            <div id="registroForm" class="auth-tab-content">
                <h2>Crear Cuenta</h2>
                <p class="auth-subtitle">Únete a TravelPlus</p>

                <form method="POST" action="{{ route('registro.store') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="nombre_apellidos">Nombre y apellidos</label>
                        <input id="nombre_apellidos" name="nombre_apellidos" type="text" required value="{{ old('nombre_apellidos') }}" placeholder="Juan García López">
                    </div>

                    <div class="form-group">
                        <label for="username">Nombre de usuario</label>
                        <input id="username" name="username" type="text" required value="{{ old('username') }}" placeholder="juangarcia">
                    </div>

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="juan@ejemplo.com">
                    </div>

                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" required value="{{ old('fecha_nacimiento') }}">
                    </div>

                    <div class="form-group">
                        <label for="reg_password">Contraseña</label>
                        <input id="reg_password" name="password" type="password" required placeholder="••••••••">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar contraseña</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn-primary">Crear Cuenta</button>
                </form>
            </div>
        </div>
    </div>
    @endguest

    <section class="profile-section">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">👤</div>
                <div class="profile-info">
                    <h1>{{ $user->nombre_apellidos }}</h1>
                    <p class="profile-email">{{ $user->email }}</p>
                    <p class="profile-location">📍 Castilla y León, España</p>
                </div>
                <button class="btn-primary" onclick="openEditProfileModal()">Editar Perfil</button>
            </div>

            <div class="profile-stats">
                <div class="stat-card">
                    <div class="stat-number">{{ $planesGuardados }}</div>
                    <div class="stat-label">Planes Guardados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $planesFinalizados }}</div>
                    <div class="stat-label">Planes Finalizados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $sitiosVisitados }}</div>
                    <div class="stat-label">Sitios Visitados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">4.8</div>
                    <div class="stat-label">Calificación</div>
                </div>
            </div>

            <div class="profile-content">
                <div class="profile-section-box">
                    <h2>Información Personal</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nombre Completo</label>
                            <p>{{ $user->nombre_apellidos }}</p>
                        </div>
                        <div class="info-item">
                            <label>Nombre de Usuario</label>
                            <p>{{ $user->username }}</p>
                        </div>
                        <div class="info-item">
                            <label>Correo Electrónico</label>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="info-item">
                            <label>Fecha de Nacimiento</label>
                            <p>{{ $user->fecha_nacimiento ? \Carbon\Carbon::parse($user->fecha_nacimiento)->format('d/m/Y') : 'No especificado' }}</p>
                        </div>
                        <div class="info-item">
                            <label>Fecha de Registro</label>
                            <p>{{ $user->created_at ? $user->created_at->format('d \d\e F, Y') : 'No disponible' }}</p>
                        </div>
                    </div>
                </div>

                <div class="profile-section-box">
                    <h2>Preferencias de Viaje</h2>
                    <div class="preferences-list">
                        <div class="preference-item">
                            <span class="pref-icon">🏨</span>
                            <div>
                                <h4>Hospedaje Favorito</h4>
                                <p>Hoteles de lujo con servicios completos</p>
                            </div>
                        </div>
                        <div class="preference-item">
                            <span class="pref-icon">🍽️</span>
                            <div>
                                <h4>Tipo de Comida</h4>
                                <p>Gastronomía local y tradicional</p>
                            </div>
                        </div>
                        <div class="preference-item">
                            <span class="pref-icon">🎨</span>
                            <div>
                                <h4>Actividades</h4>
                                <p>Museos, arte y cultura</p>
                            </div>
                        </div>
                        <div class="preference-item">
                            <span class="pref-icon">🏖️</span>
                            <div>
                                <h4>Tipo de Viaje</h4>
                                <p>Playa y naturaleza</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <!-- Modal de edición de perfil -->
    <div id="editProfileModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 520px;">
            <button class="modal-close" onclick="closeEditProfileModal()">&times;</button>

            <div class="modal-body" style="padding-top: 0;">
                <h2 style="margin-bottom: 0.5rem;">Editar Perfil</h2>
                <p style="color: #666; margin-bottom: 1.5rem;">Actualiza tu información personal</p>

                <form method="POST" action="{{ route('perfil.update') }}" class="edit-profile-form">
                    @csrf

                    <div class="form-group">
                        <label for="modal_nombre_apellidos">Nombre Completo</label>
                        <input
                            id="modal_nombre_apellidos"
                            name="nombre_apellidos"
                            type="text"
                            required
                            value="{{ old('nombre_apellidos', $user->nombre_apellidos) }}"
                            placeholder="Juan García López"
                        >
                        @error('nombre_apellidos')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="modal_email">Correo Electrónico</label>
                        <input
                            id="modal_email"
                            name="email"
                            type="email"
                            required
                            value="{{ old('email', $user->email) }}"
                            placeholder="juan@ejemplo.com"
                        >
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="modal_fecha_nacimiento">Fecha de Nacimiento</label>
                        <input
                            id="modal_fecha_nacimiento"
                            name="fecha_nacimiento"
                            type="date"
                            value="{{ old('fecha_nacimiento', $user->fecha_nacimiento) }}"
                        >
                        @error('fecha_nacimiento')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                        <h3 style="margin-bottom: 0.75rem;">Cambiar Contraseña</h3>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.75rem;">Deja estos campos vacíos si no deseas cambiar tu contraseña</p>

                        <div class="form-group">
                            <label for="modal_password">Nueva Contraseña</label>
                            <input
                                id="modal_password"
                                name="password"
                                type="password"
                                placeholder="••••••••"
                            >
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="modal_password_confirmation">Confirmar Contraseña</label>
                            <input
                                id="modal_password_confirmation"
                                name="password_confirmation"
                                type="password"
                                placeholder="••••••••"
                            >
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                        <button type="submit" class="btn-primary">Guardar Cambios</button>
                        <button type="button" class="btn-secondary" onclick="closeEditProfileModal()">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function openEditProfileModal() {
            document.getElementById('editProfileModal').classList.add('active');
        }

        function closeEditProfileModal() {
            document.getElementById('editProfileModal').classList.remove('active');
        }

        window.addEventListener('load', function() {
            @if ($errors->any())
                openEditProfileModal();
            @endif
        });
    </script>
</body>
</html>
