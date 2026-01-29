<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Plan - TravelPlus</title>
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

    <section class="plan-detail-section">
        <div class="plan-detail-container">
            <div class="plan-detail-header">
                <div>
                    <h1>Fin de Semana en Barcelona</h1>
                    <p class="plan-location">📍 Barcelona, Cataluña</p>
                </div>
                <div class="plan-actions">
                    <button class="btn-primary" onclick="editarPlan()">✏️ Editar</button>
                    <button class="btn-secondary" onclick="compartirPlan()">📤 Compartir</button>
                </div>
            </div>

            <div class="plan-overview">
                <div class="overview-item">
                    <span class="overview-icon">📅</span>
                    <div>
                        <h4>Fechas</h4>
                        <p>15 - 17 Febrero, 2026</p>
                    </div>
                </div>
                <div class="overview-item">
                    <span class="overview-icon">⏱️</span>
                    <div>
                        <h4>Duración</h4>
                        <p>3 días</p>
                    </div>
                </div>
                <div class="overview-item">
                    <span class="overview-icon">👥</span>
                    <div>
                        <h4>Viajeros</h4>
                        <p>2 personas</p>
                    </div>
                </div>
                <div class="overview-item">
                    <span class="overview-icon">💰</span>
                    <div>
                        <h4>Presupuesto</h4>
                        <p>€1,200 estimado</p>
                    </div>
                </div>
            </div>

            <div class="plan-details-content">
                <div class="detail-column">
                    <h2>Mi Itinerario</h2>

                    <div class="itinerary-day">
                        <h3>Día 1 - Viernes 15 Febrero</h3>
                        <div class="itinerary-item">
                            <div class="itinerary-time">09:00 AM</div>
                            <div class="itinerary-content">
                                <h4>✈️ Llegada al Aeropuerto</h4>
                                <p>Vuelo desde Madrid a Barcelona</p>
                            </div>
                        </div>
                        <div class="itinerary-item">
                            <div class="itinerary-time">02:00 PM</div>
                            <div class="itinerary-content">
                                <h4>🏨 Check-in Hotel</h4>
                                <p>Barcelona Nights Luxury - Paseo de Gracia</p>
                                <span class="itinerary-badge">Hotel</span>
                            </div>
                        </div>
                        <div class="itinerary-item">
                            <div class="itinerary-time">06:00 PM</div>
                            <div class="itinerary-content">
                                <h4>🚶 Paseo Turístico</h4>
                                <p>Explorar Paseo de Gracia y alrededores</p>
                            </div>
                        </div>
                        <div class="itinerary-item">
                            <div class="itinerary-time">08:30 PM</div>
                            <div class="itinerary-content">
                                <h4>🍽️ Cena</h4>
                                <p>Catalan Kitchen - Eixample</p>
                                <span class="itinerary-badge">Restaurante</span>
                            </div>
                        </div>
                    </div>

                    <div class="itinerary-day">
                        <h3>Día 2 - Sábado 16 Febrero</h3>
                        <div class="itinerary-item">
                            <div class="itinerary-time">09:00 AM</div>
                            <div class="itinerary-content">
                                <h4>🎨 Museo Picasso Barcelona</h4>
                                <p>Colección más importante de Picasso</p>
                                <span class="itinerary-badge">Museo</span>
                            </div>
                        </div>
                        <div class="itinerary-item">
                            <div class="itinerary-time">12:30 PM</div>
                            <div class="itinerary-content">
                                <h4>🍴 Almuerzo</h4>
                                <p>Seafood Paradise - Port Vell</p>
                                <span class="itinerary-badge">Restaurante</span>
                            </div>
                        </div>
                        <div class="itinerary-item">
                            <div class="itinerary-time">03:00 PM</div>
                            <div class="itinerary-content">
                                <h4>🏰 Sagrada Familia</h4>
                                <p>Basílica modernista de Gaudí - Patrimonio UNESCO</p>
                                <span class="itinerary-badge">Atracción</span>
                            </div>
                        </div>
                        <div class="itinerary-item">
                            <div class="itinerary-time">07:00 PM</div>
                            <div class="itinerary-content">
                                <h4>🎭 Espectáculo</h4>
                                <p>Circo del Mundo - Montjuïc</p>
                            </div>
                        </div>
                    </div>

                    <div class="itinerary-day">
                        <h3>Día 3 - Domingo 17 Febrero</h3>
                        <div class="itinerary-item">
                            <div class="itinerary-time">10:00 AM</div>
                            <div class="itinerary-content">
                                <h4>🌳 Park Güell</h4>
                                <p>Parque con mosaicos y vistas increíbles</p>
                                <span class="itinerary-badge">Atracción</span>
                            </div>
                        </div>
                        <div class="itinerary-item">
                            <div class="itinerary-time">01:00 PM</div>
                            <div class="itinerary-content">
                                <h4>🍽️ Comida</h4>
                                <p>Montjuïc Flavors - Montjuïc</p>
                                <span class="itinerary-badge">Restaurante</span>
                            </div>
                        </div>
                        <div class="itinerary-item">
                            <div class="itinerary-time">04:00 PM</div>
                            <div class="itinerary-content">
                                <h4>🛍️ Compras</h4>
                                <p>Paseo de Gracia y centro comercial</p>
                            </div>
                        </div>
                        <div class="itinerary-item">
                            <div class="itinerary-time">07:00 PM</div>
                            <div class="itinerary-content">
                                <h4>✈️ Vuelta a Casa</h4>
                                <p>Vuelo a Madrid</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-column">
                    <h2>Resumen del Plan</h2>

                    <div class="summary-box">
                        <h3>🏨 Hospedaje</h3>
                        <div class="summary-item">
                            <p><strong>Barcelona Nights Luxury</strong></p>
                            <p>Lujo moderno con vistas a la ciudad</p>
                            <p class="item-price">€400 x 3 noches = €1,200</p>
                            <small>⭐⭐⭐⭐⭐ 4.9</small>
                        </div>
                    </div>

                    <div class="summary-box">
                        <h3>🍽️ Restaurantes</h3>
                        <div class="summary-item">
                            <p><strong>Catalan Kitchen</strong></p>
                            <p>Auténtica cocina catalana</p>
                            <p class="item-price">€45</p>
                        </div>
                        <div class="summary-item">
                            <p><strong>Seafood Paradise</strong></p>
                            <p>Excelentes mariscos frescos</p>
                            <p class="item-price">€65</p>
                        </div>
                        <div class="summary-item">
                            <p><strong>Montjuïc Flavors</strong></p>
                            <p>Cocina moderna con vistas</p>
                            <p class="item-price">€55</p>
                        </div>
                    </div>

                    <div class="summary-box">
                        <h3>🎨 Atracciones</h3>
                        <div class="summary-item">
                            <p><strong>Museo Picasso Barcelona</strong></p>
                            <p class="item-price">€14</p>
                        </div>
                        <div class="summary-item">
                            <p><strong>Sagrada Familia</strong></p>
                            <p class="item-price">€26</p>
                        </div>
                        <div class="summary-item">
                            <p><strong>Park Güell</strong></p>
                            <p class="item-price">€14</p>
                        </div>
                        <div class="summary-item">
                            <p><strong>Circo del Mundo</strong></p>
                            <p class="item-price">€35</p>
                        </div>
                    </div>

                    <div class="summary-box">
                        <h3>💰 Resumen de Costos</h3>
                        <div class="cost-breakdown">
                            <div class="cost-item">
                                <span>Hospedaje:</span>
                                <span>€1,200</span>
                            </div>
                            <div class="cost-item">
                                <span>Restaurantes:</span>
                                <span>€165</span>
                            </div>
                            <div class="cost-item">
                                <span>Atracciones:</span>
                                <span>€89</span>
                            </div>
                            <div class="cost-item total">
                                <span>Total:</span>
                                <span>€1,454</span>
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
</body>
</html>
