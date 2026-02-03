<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('partials.navbar')

    @include('partials.login-modal')

    <section class="contact-section">
        <div class="contact-container">
            <h1>Contacta con Nosotros</h1>
            <p class="contact-subtitle">Estamos aquí para ayudarte con cualquier pregunta o sugerencia</p>

            <div class="contact-content">
                <div class="contact-form-container">
                    <h2>Envía tu Mensaje</h2>
                    <form id="contactForm" class="contact-form" method="POST" action="{{ route('contacto.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <select id="asunto" name="asunto" required>
                                <option value="">Selecciona un asunto</option>
                                <option value="soporte">Soporte Técnico</option>
                                <option value="sugerencia">Sugerencia</option>
                                <option value="reportar">Reportar Error</option>
                                <option value="asociarse">Asociarse con Nosotros</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mensaje">Mensaje</label>
                            <textarea id="mensaje" name="mensaje" rows="6" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="prioridad">Prioridad</label>
                            <select id="prioridad" name="prioridad">
                                <option value="normal">Normal</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-primary">Enviar Mensaje</button>
                    </form>
                </div>

                <div class="contact-info-container">
                    <h2>Información de Contacto</h2>

                    <div class="contact-info-box">
                        <h3>📧 Email</h3>
                        <p>soporte@travelplus.com</p>
                        <small>Responderemos en 24 horas</small>
                    </div>

                    <div class="contact-info-box">
                        <h3>📞 Teléfono</h3>
                        <p>+34 900 123 456</p>
                        <small>Lunes a Viernes, 9:00 - 18:00</small>
                    </div>

                    <div class="contact-info-box">
                        <h3>💬 Chat en Vivo</h3>
                        <p>Disponible 24/7 para usuarios Premium</p>
                        <button class="btn-small" onclick="abrirChat()">Iniciar Chat</button>
                    </div>

                    <div class="contact-info-box">
                        <h3>🏢 Oficina Principal</h3>
                        <p>Calle Principal, 123<br>Madrid, 28001<br>España</p>
                    </div>

                    <div class="contact-info-box">
                        <h3>🕐 Horarios de Atención</h3>
                        <p>Lunes - Viernes: 9:00 - 18:00<br>
                        Sábado: 10:00 - 14:00<br>
                        Domingo: Cerrado</p>
                    </div>

                    <div class="social-links">
                        <h3>Síguenos</h3>
                        <div class="social-icons">
                            <a href="#" class="social-icon">f</a>
                            <a href="#" class="social-icon">𝕏</a>
                            <a href="#" class="social-icon">📷</a>
                            <a href="#" class="social-icon">▶️</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-link">
                <h3>¿Buscas respuestas rápidas?</h3>
                <p>Consulta nuestras Preguntas Frecuentes para soluciones inmediatas</p>
                <a href="{{ route('preguntas-frecuentes') }}" class="btn-secondary">Ver FAQ</a>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
