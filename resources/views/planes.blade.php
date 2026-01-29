<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planear Viaje - TravelPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">✈️ TravelPlus</div>
            <ul class="nav-links">
                <li><a href="{{ route('index') }}">Inicio</a></li>
                <li><a href="{{ route('destinos') }}">Destinos</a></li>
                <li><a href="{{ route('planes') }}" class="active">Crear Plan</a></li>
                <li><a href="{{ route('mis-planes') }}">Mis Planes</a></li>
                <li><a href="{{ route('perfil') }}">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <section class="planes-section">
        <div class="planes-container">
            <h1>Planifica tu próximo viaje</h1>

            <div class="filters-box">
                <div class="filter-group">
                    <label for="provincia">Selecciona la Provincia</label>
                    <select id="provincia" onchange="filtrarDestinos()">
                        <option value="">-- Elige una provincia --</option>
                        <option value="Madrid">Madrid</option>
                        <option value="Barcelona">Barcelona</option>
                        <option value="Valencia">Valencia</option>
                        <option value="Sevilla">Sevilla</option>
                        <option value="Bilbao">Bilbao</option>
                        <option value="Málaga">Málaga</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="dias">¿Cuántos días?</label>
                    <select id="dias" onchange="filtrarDestinos()">
                        <option value="">-- Elige duración --</option>
                        <option value="1">1 día</option>
                        <option value="2">2 días</option>
                        <option value="3">3 días</option>
                        <option value="4">4 días</option>
                        <option value="5">5 días</option>
                        <option value="7">7 días</option>
                    </select>
                </div>

                <button class="btn-primary" onclick="filtrarDestinos()">Buscar</button>
            </div>

            <div id="resultados" class="resultados-container">
                <p class="placeholder-text">Selecciona una provincia y duración para ver opciones disponibles</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
