<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar Destinos - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}" class="active">Destinos</a></li>
                @auth
                    <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                    <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                    <li><a href="{{ route('perfil') }}">Perfil</a></li>
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

    <section class="explore-section">
        <div class="explore-header">
            <h1>Explora Nuestros Destinos</h1>
            <p>Descubre lugares increíbles para tus próximas vacaciones</p>
        </div>



        <div class="destinations-grid">
            <!-- Ávila -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #A89B9B, #9D8B7E);">
                    🏰
                </div>
                <div class="destination-content">
                    <h3>Ávila</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Murallas medievales, patrimonio histórico y arquitectura antigua</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Ávila" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Ávila" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Ávila" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Ávila" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Burgos -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #9D8B7E, #8B7B7B);">
                    ⛪
                </div>
                <div class="destination-content">
                    <h3>Burgos</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Catedral gótica, caminos de peregrinación y tradición medieval</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Burgos" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Burgos" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Burgos" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Burgos" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- León -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #C0B5AA, #A89B9B);">
                    👑
                </div>
                <div class="destination-content">
                    <h3>León</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Camino de Santiago, basílica románica y rica historia medieval</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=León" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=León" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=León" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=León" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Palencia -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #8B7B7B, #D4CCC4);">
                    🌾
                </div>
                <div class="destination-content">
                    <h3>Palencia</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Catedral románica, paisajes rurales y patrimonio agrario</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Palencia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Palencia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Palencia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Palencia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Segovia -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #A89B9B, #C0B5AA);">
                    👸
                </div>
                <div class="destination-content">
                    <h3>Segovia</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Alcázar de cuento de hadas, acueducto romano y gastronomía</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Segovia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Segovia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Segovia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Segovia" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Soria -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #9D8B7E, #A89B9B);">
                    🏞️
                </div>
                <div class="destination-content">
                    <h3>Soria</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Naturaleza salvaje, monasterio de San Juan de Duero</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Soria" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Soria" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Soria" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Soria" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Valladolid -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #C0B5AA, #9D8B7E);">
                    🎪
                </div>
                <div class="destination-content">
                    <h3>Valladolid</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Capital cultural, museos excepcionales y vida urbana moderna</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Valladolid" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Valladolid" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Valladolid" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Valladolid" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Zamora -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #8B7B7B, #A89B9B);">
                    🏛️
                </div>
                <div class="destination-content">
                    <h3>Zamora</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Catedral románica, fortaleza histórica y tradición medieval</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Zamora" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Zamora" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Zamora" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Zamora" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
                </div>
            </div>

            <!-- Salamanca -->
            <div class="destination-card">
                <div class="destination-image" style="background: linear-gradient(135deg, #D4CCC4, #A89B9B);">
                    🎓
                </div>
                <div class="destination-content">
                    <h3>Salamanca</h3>
                    <p class="destination-subtitle">Castilla y León</p>
                    <p class="destination-desc">Universidad histórica, Plaza Mayor dorada y arquitectura renacentista</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 10px;">
                        <a href="{{ route('hoteles') }}?provincia=Salamanca" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Hoteles</a>
                        <a href="{{ route('restaurantes') }}?provincia=Salamanca" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Restaurantes</a>
                        <a href="{{ route('museos') }}?provincia=Salamanca" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Museos</a>
                        <a href="{{ route('fiestas') }}?provincia=Salamanca" class="btn-small" style="font-size: 0.8rem; padding: 8px 5px;">Fiestas</a>
                    </div>
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
