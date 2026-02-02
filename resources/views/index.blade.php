<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelPlus - Planifica tus viajes</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}" class="active">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
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

    <!-- Sección: Qué es TravelPlus -->
    <section class="about-section">
        <div class="about-container">
            <h1>Descubre Castilla y León como nunca antes</h1>
            <p class="about-lead">
                TravelPlus es tu compañero perfecto para explorar los rincones más fascinantes de Castilla y León. 
                Creamos itinerarios personalizados que te conectan con el patrimonio histórico, la gastronomía excepcional 
                y las experiencias únicas que solo esta tierra milenaria puede ofrecer.
            </p>
            <div class="about-highlights">
                <div class="highlight-item">
                    <span class="highlight-icon">🏰</span>
                    <h3>Patrimonio Mundial</h3>
                    <p>Castillos, catedrales y monumentos declarados Patrimonio de la Humanidad te esperan en cada provincia</p>
                </div>
                <div class="highlight-item">
                    <span class="highlight-icon">🍷</span>
                    <h3>Gastronomía de Excelencia</h3>
                    <p>Degusta los mejores vinos de Ribera del Duero, el lechazo asado y productos con Denominación de Origen</p>
                </div>
                <div class="highlight-item">
                    <span class="highlight-icon">🌄</span>
                    <h3>Naturaleza Virgen</h3>
                    <p>Desde los Picos de Europa hasta las Hoces del Duratón, paisajes que te dejarán sin aliento</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Por qué usar TravelPlus -->
    <section class="features">
        <h2>¿Por qué usar TravelPlus?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon">🏨</span>
                <h3>Hoteles</h3>
                <p>Encuentra los mejores hospedajes en cualquier destino</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🍽️</span>
                <h3>Restaurantes</h3>
                <p>Descubre la gastronomía local de cada región</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🎨</span>
                <h3>Museos</h3>
                <p>Explora la cultura y arte de cada lugar</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🎪</span>
                <h3>Atracciones</h3>
                <p>Actividades y entretenimiento para todos</p>
            </div>
        </div>
    </section>

    <!-- Sección: Descubre tu próximo destino -->
    <section class="hero">
        <div class="hero-content">
            <h1>Descubre tu próximo destino</h1>
            <p>Planifica viajes inolvidables por Castilla y León en minutos</p>
            <a href="{{ route('destinos') }}" class="btn-primary">Explorar Destinos</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
