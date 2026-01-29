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
                <li><a href="{{ route('planes') }}">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}" class="active">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <section class="profile-section">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">👤</div>
                <div class="profile-info">
                    <h1>Juan García López</h1>
                    <p class="profile-email">juan.garcia@email.com</p>
                    <p class="profile-location">📍 Madrid, España</p>
                </div>
                <button class="btn-primary" onclick="editarPerfil()">Editar Perfil</button>
            </div>

            <div class="profile-stats">
                <div class="stat-card">
                    <div class="stat-number">7</div>
                    <div class="stat-label">Viajes Completados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Planes Guardados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">28</div>
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
                            <p>Juan García López</p>
                        </div>
                        <div class="info-item">
                            <label>Correo Electrónico</label>
                            <p>juan.garcia@email.com</p>
                        </div>
                        <div class="info-item">
                            <label>Teléfono</label>
                            <p>+34 912 345 678</p>
                        </div>
                        <div class="info-item">
                            <label>Provincia</label>
                            <p>Madrid</p>
                        </div>
                        <div class="info-item">
                            <label>Fecha de Registro</label>
                            <p>15 de Enero, 2026</p>
                        </div>
                        <div class="info-item">
                            <label>Miembro Premium</label>
                            <p>⭐ Activo</p>
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

                <div class="profile-section-box">
                    <h2>Mis Reseñas Recientes</h2>
                    <div class="reviews-list">
                        <div class="review-item">
                            <div class="review-header">
                                <h4>Hotel Real Elegance - Madrid</h4>
                                <span class="review-rating">⭐⭐⭐⭐⭐ 5.0</span>
                            </div>
                            <p>"Experiencia increíble, personal muy atento y habitaciones impecables"</p>
                            <small>Hace 2 semanas</small>
                        </div>
                        <div class="review-item">
                            <div class="review-header">
                                <h4>Restaurante El Jardín Gourmet</h4>
                                <span class="review-rating">⭐⭐⭐⭐ 4.7</span>
                            </div>
                            <p>"Excelente comida y presentación. El servicio fue muy profesional."</p>
                            <small>Hace 1 mes</small>
                        </div>
                    </div>
                </div>

                <div class="profile-section-box">
                    <h2>Configuración de Cuenta</h2>
                    <div class="settings-list">
                        <button class="setting-button">🔐 Cambiar Contraseña</button>
                        <button class="setting-button">🔔 Notificaciones</button>
                        <button class="setting-button">🌐 Privacidad</button>
                        <button class="setting-button" style="background-color: #C0B5AA;">🚪 Cerrar Sesión</button>
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
