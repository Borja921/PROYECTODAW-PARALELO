<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas Frecuentes - TravelPlus</title>
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

    <section class="faq-section">
        <div class="faq-container">
            <h1>Preguntas Frecuentes</h1>
            <p class="faq-subtitle">Encuentra respuestas a las preguntas más comunes</p>

            <div class="faq-grid">
                <div class="faq-column">
                    <h2>Cuenta y Registro</h2>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Cómo creo una cuenta?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Haz clic en "Registro" en el menú principal, completa el formulario con tus datos y acepta los términos. ¡Listo! Tu cuenta estará activa inmediatamente.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Es necesario registrarse para usar TravelPlus?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Puedes explorar destinos sin registro, pero necesitas una cuenta para crear y guardar tus planes de viaje personalizados.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Puedo cambiar mi contraseña?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Sí, desde tu perfil puedes acceder a "Cambiar Contraseña" en la sección de configuración de cuenta.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Cómo elimino mi cuenta?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Contacta a nuestro equipo de soporte a través de la página de contacto. Procesaremos tu solicitud en 48 horas.</p>
                        </div>
                    </div>
                </div>

                <div class="faq-column">
                    <h2>Planes y Viajes</h2>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Cómo creo un plan de viaje?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Ve a "Crear Plan", selecciona la provincia y la duración de tu viaje. Luego podrás explorar hoteles, restaurantes, museos y atracciones disponibles.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Puedo editar un plan ya creado?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Claro que sí. Ve a "Mis Planes", selecciona el plan y haz clic en "Editar". Puedes hacer cambios sin limitaciones.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Cuántos planes puedo crear?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Con una cuenta gratuita puedes crear hasta 5 planes. Con membresía premium, planes ilimitados.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Puedo compartir mis planes?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Sí, en la vista de detalles del plan encontrarás opciones para compartir por correo o redes sociales.</p>
                        </div>
                    </div>
                </div>

                <div class="faq-column">
                    <h2>Destinos y Reservas</h2>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿TravelPlus realiza las reservas por mí?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>No, TravelPlus es una plataforma de planificación. Te mostramos opciones y puedes reservar directamente en los sitios o contactar los establecimientos.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Qué provincias cubren?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Actualmente cubrimos las principales provincias: Madrid, Barcelona, Valencia, Sevilla, Bilbao y Málaga. Pronto expandiremos a más destinos.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Cómo se actualizan los precios?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Los precios se actualizan regularmente. Los mostrados son orientativos. Te recomendamos confirmar precios en el sitio original.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Cómo dejan reseñas otros viajeros?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Después de visitar un lugar, puedes dejar reseñas y ratings en tu perfil para ayudar a otros viajeros.</p>
                        </div>
                    </div>
                </div>

                <div class="faq-column">
                    <h2>Membresía Premium</h2>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Cuál es el costo de la membresía premium?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>La membresía premium cuesta €9.99/mes o €79.99/año. Obtén tu primer mes gratis como nuevo usuario.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Qué incluye la membresía premium?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Planes ilimitados, soporte prioritario, acceso a ofertas exclusivas, descuentos en hoteles asociados y mucho más.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Puedo cancelar la membresía en cualquier momento?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Sí, sin problemas. Puedes cancelar desde tu perfil sin penalizaciones. Si cambias de opinión, puedes reactivarla cuando quieras.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>¿Hay descuentos para grupos?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Sí, para grupos de 5 o más personas ofrecemos descuentos especiales. Contacta a nuestro equipo para más información.</p>
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
</body>
</html>
