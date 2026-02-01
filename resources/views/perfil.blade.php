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
                @auth
                    <li><a href="{{ route('destinos') }}">Destinos</a></li>
                    <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                    <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                    <li><a href="{{ route('perfil') }}" class="active">Perfil</a></li>
                @else
                    <li><a href="#" onclick="showLoginModal()">Iniciar Sesión</a></li>
                    <li><a href="#" onclick="showRegisterModal()">Registrarse</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <section class="profile-section">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">👤</div>
                <div class="profile-info">
                    @if(isset($user->username))
                        <h2 style="margin-bottom:0;">{{ $user->username }}</h2>
                    @else
                        <h2 style="margin-bottom:0;">{{ $user->name }}</h2>
                    @endif
                    <div style="font-size:1.2em; color:#555; margin-bottom:2px;">{{ $user->name }}</div>
                    <p class="profile-email">{{ $user->email }}</p>
                    <!-- Puedes agregar más campos del usuario aquí si existen, como provincia o ubicación -->
                    @if(isset($user->provincia))
                        <p class="profile-location">📍 {{ $user->provincia }}</p>
                    @endif
                </div>
                <button class="btn-primary" onclick="mostrarModalConfiguracion()">Editar Perfil</button>
                <a href="{{ route('logout') }}" class="btn-danger" style="background-color:#6c757d; color:white; margin-left:10px; border:none; padding:10px 18px; border-radius:5px; cursor:pointer; text-decoration:none; display:inline-block;">Cerrar Sesión</a>
            </div>

            <div class="profile-content">
                <div class="profile-section-box">
                    <h2>Información Personal</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nombre Completo</label>
                            <p>{{ $user->name }}</p>
                        </div>
                        <div class="info-item">
                            <label>Correo Electrónico</label>
                            <p>{{ $user->email }}</p>
                        </div>
                        @if(isset($user->telefono))
                        <div class="info-item">
                            <label>Teléfono</label>
                            <p>{{ $user->telefono }}</p>
                        </div>
                        @endif
                        @if(isset($user->provincia))
                        <div class="info-item">
                            <label>Provincia</label>
                            <p>{{ $user->provincia }}</p>
                        </div>
                        @endif
                        <div class="info-item">
                            <label>Fecha de Registro</label>
                            <p>{{ $user->created_at ? $user->created_at->format('d \d\e F, Y') : '' }}</p>
                        </div>
                    </div>
                </div>

                <div class="profile-section-box">
                    <h2>Preferencias de Viaje</h2>
                    <div class="preferences-list">
                        <div class="preference-item">
                        </div>
                    </div>
                </div>

                <div class="profile-section-box">
                    <h2>Mis Reseñas Recientes</h2>
                    <div class="reviews-list">
                        <div class="review-item">
                        </div>
                    </div>
                </div>

                <!-- Modal de Configuración de Cuenta -->
                <div id="modal-configuracion" class="modal-configuracion" style="display:none;">
                    <div class="modal-content-configuracion">
                        <span class="close-modal" onclick="cerrarModalConfiguracion()">&times;</span>
                        <h2>Configuración de Cuenta</h2>
                        <div class="settings-list">
                            <button class="setting-button">🔐 Cambiar Contraseña</button>
                            <button class="setting-button">🔔 Notificaciones</button>
                            <button class="setting-button">🌐 Privacidad</button>
                                <div style="margin-top:30px; display:flex; flex-direction:column; gap:10px;">
                                    <button class="setting-button" style="background-color: #e74c3c; color:white;">🗑️ Eliminar cuenta</button>
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

    <script src="{{ asset('js/script.js') }}"></script>
    <style>
    .modal-configuracion {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }
    .modal-content-configuracion {
        background-color: #fff;
        margin: 8% auto;
        padding: 30px 30px 20px 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.2);
        position: relative;
        animation: modalFadeIn 0.3s;
    }
    @keyframes modalFadeIn {
        from { transform: translateY(-40px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .close-modal {
        position: absolute;
        top: 10px;
        right: 18px;
        font-size: 2em;
        color: #888;
        cursor: pointer;
        font-weight: bold;
    }
    .close-modal:hover {
        color: #e74c3c;
    }
    </style>
    <script>
    function mostrarModalConfiguracion() {
        document.getElementById('modal-configuracion').style.display = 'block';
    }
    function cerrarModalConfiguracion() {
        document.getElementById('modal-configuracion').style.display = 'none';
    }
    // Cerrar modal al hacer click fuera del contenido
    window.onclick = function(event) {
        var modal = document.getElementById('modal-configuracion');
        if (event.target === modal) {
            cerrarModalConfiguracion();
        }
    }
    </script>
</body>
</html>
