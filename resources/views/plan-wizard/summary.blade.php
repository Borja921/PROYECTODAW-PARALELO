<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen del Plan - TravelPlus</title>
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

<div class="container">
    <h1>Resumen de tu plan</h1>

    <div style="margin-bottom:12px;">
        <strong>Provincia:</strong> {{ $draft['provincia'] }} — <strong>Municipio:</strong> {{ $draft['municipio'] }}
        <div><strong>Fechas:</strong> {{ $draft['start_date'] }} → {{ $draft['end_date'] }}</div>
    </div>

    <div style="margin-bottom:20px;">
        <h3>Nombre del Plan</h3>
        <div class="plan-name-section">
            <label for="plan-name">Escribe un nombre para tu plan:</label>
            <input type="text" id="plan-name" name="plan_name" placeholder="Ej: Viaje a {{ $draft['municipio'] }} - {{ date('Y') }}" maxlength="100" class="plan-name-input">
            <small class="plan-name-help">Este nombre te ayudará a identificar tu plan más tarde</small>
        </div>
    </div>

    <div style="margin-bottom:12px;">
        <h3>Elementos Guardados</h3>

        <div id="saved-items-container">
            <!-- Hoteles guardados -->
            <div class="saved-section">
                <h4>🏨 Hoteles Guardados</h4>
                <div id="saved-hotels-list" class="saved-items-list">
                    <p class="no-items">No hay hoteles guardados</p>
                </div>
            </div>

            <!-- Museos guardados -->
            <div class="saved-section">
                <h4>� Museos Guardados</h4>
                <div id="saved-museums-list" class="saved-items-list">
                    <p class="no-items">No hay museos guardados</p>
                </div>
            </div>

            <!-- Restaurantes guardados -->
            <div class="saved-section">
                <h4>�️ Restaurantes Guardados</h4>
                <div id="saved-restaurants-list" class="saved-items-list">
                    <p class="no-items">No hay restaurantes guardados</p>
                </div>
            </div>

            <!-- Fiestas guardadas -->
            <div class="saved-section">
                <h4>🎪 Fiestas Guardadas</h4>
                <div id="saved-festivals-list" class="saved-items-list">
                    <p class="no-items">No hay fiestas guardadas</p>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('plan.wizard.finalize') }}" id="finalize-plan-form">
        @csrf
        <input type="hidden" name="nombre_plan" id="form_nombre_plan">
        <input type="hidden" name="listado_hoteles" id="form_listado_hoteles">
        <input type="hidden" name="listado_museos" id="form_listado_museos">
        <input type="hidden" name="listado_restaurantes" id="form_listado_restaurantes">
        <input type="hidden" name="listado_fiestas" id="form_listado_fiestas">
        
        <div style="display:flex;gap:8px;">
            <a class="btn-secondary" href="{{ route('plan.wizard.fiestas') }}">Atrás</a>
            <button type="submit" class="btn-primary" onclick="return prepareFormData()">Confirmar Plan</button>
        </div>
    </form>
</div>

<style>
.plan-name-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.plan-name-section label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #495057;
}

.plan-name-input {
    width: 100%;
    padding: 12px;
    border: 2px solid #ced4da;
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

.plan-name-input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

.plan-name-help {
    display: block;
    margin-top: 6px;
    color: #6c757d;
    font-size: 14px;
}

.saved-section {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.saved-section h4 {
    margin: 0 0 10px 0;
    color: #333;
}

.saved-items-list {
    display: grid;
    gap: 10px;
}

.saved-item {
    background: white;
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #eee;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.saved-item h5 {
    margin: 0 0 5px 0;
    color: #2c3e50;
}

.saved-item p {
    margin: 3px 0;
    font-size: 0.9em;
    color: #666;
}

.no-items {
    color: #999;
    font-style: italic;
    text-align: center;
    padding: 20px;
}

.remove-item {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.8em;
    float: right;
}

.remove-item:hover {
    background: #c0392b;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadSavedItems();
    loadPlanName();

    // Guardar nombre del plan cuando el usuario escriba
    const planNameInput = document.getElementById('plan-name');
    planNameInput.addEventListener('input', function() {
        sessionStorage.setItem('planName', this.value);
    });
});

function loadPlanName() {
    const savedPlanName = sessionStorage.getItem('planName');
    if (savedPlanName) {
        document.getElementById('plan-name').value = savedPlanName;
    }
}

function loadSavedItems() {
    // Cargar hoteles
    const savedHotels = JSON.parse(sessionStorage.getItem('savedHotels') || '[]');
    displaySavedItems('saved-hotels-list', savedHotels, 'hotel');

    // Cargar museos
    const savedMuseums = JSON.parse(sessionStorage.getItem('savedMuseos') || '[]');
    displaySavedItems('saved-museums-list', savedMuseums, 'museum');

    // Cargar restaurantes
    const savedRestaurants = JSON.parse(sessionStorage.getItem('savedRestaurantes') || '[]');
    displaySavedItems('saved-restaurants-list', savedRestaurants, 'restaurant');

    // Cargar fiestas
    const savedFestivals = JSON.parse(sessionStorage.getItem('savedFiestas') || '[]');
    displaySavedItems('saved-festivals-list', savedFestivals, 'festival');
}

function displaySavedItems(containerId, items, type) {
    const container = document.getElementById(containerId);

    if (items.length === 0) {
        container.innerHTML = '<p class="no-items">No hay elementos guardados</p>';
        return;
    }

    let html = '';
    items.forEach((item, index) => {
        html += `
            <div class="saved-item">
                <button class="remove-item" onclick="removeItem('${type}', ${index})">Quitar</button>
                <h5>${item.name}</h5>
                <p>📍 ${item.locality || ''}, ${item.province || ''}</p>
                ${item.address ? `<p><strong>Dirección:</strong> ${item.address}</p>` : ''}
                ${item.phone ? `<p><strong>Teléfono:</strong> ${item.phone}</p>` : ''}
                ${item.email ? `<p><strong>Email:</strong> ${item.email}</p>` : ''}
                ${item.website ? `<p><strong>Web:</strong> <a href="${item.website}" target="_blank">Visitar</a></p>` : ''}
                ${item.start_date ? `<p><strong>Fecha:</strong> ${item.start_date}</p>` : ''}
            </div>
        `;
    });

    container.innerHTML = html;
}

function removeItem(type, index) {
    let storageKey = '';
    switch(type) {
        case 'hotel': storageKey = 'savedHotels'; break;
        case 'restaurant': storageKey = 'savedRestaurantes'; break;
        case 'museum': storageKey = 'savedMuseos'; break;
        case 'festival': storageKey = 'savedFiestas'; break;
    }

    let items = JSON.parse(sessionStorage.getItem(storageKey) || '[]');
    items.splice(index, 1);
    sessionStorage.setItem(storageKey, JSON.stringify(items));

    // Recargar la vista
    loadSavedItems();
}

function prepareFormData() {
    // Validar que hay un nombre de plan
    const planName = document.getElementById('plan-name').value.trim();
    if (!planName) {
        alert('Por favor, escribe un nombre para tu plan antes de continuar.');
        document.getElementById('plan-name').focus();
        return false;
    }
    
    document.getElementById('form_nombre_plan').value = planName;
    
    // Obtener todos los elementos guardados
    const savedHotels = JSON.parse(sessionStorage.getItem('savedHotels') || '[]');
    const savedMuseos = JSON.parse(sessionStorage.getItem('savedMuseos') || '[]');
    const savedRestaurantes = JSON.parse(sessionStorage.getItem('savedRestaurantes') || '[]');
    const savedFiestas = JSON.parse(sessionStorage.getItem('savedFiestas') || '[]');
    
    // Convertir a JSON y asignar a los campos hidden
    document.getElementById('form_listado_hoteles').value = JSON.stringify(savedHotels);
    document.getElementById('form_listado_museos').value = JSON.stringify(savedMuseos);
    document.getElementById('form_listado_restaurantes').value = JSON.stringify(savedRestaurantes);
    document.getElementById('form_listado_fiestas').value = JSON.stringify(savedFiestas);
    
    // Limpiar sessionStorage después de enviar
    setTimeout(() => {
        sessionStorage.removeItem('savedHotels');
        sessionStorage.removeItem('savedMuseos');
        sessionStorage.removeItem('savedRestaurantes');
        sessionStorage.removeItem('savedFiestas');
        sessionStorage.removeItem('planName');
    }, 100);
    
    return true; // Permitir que el formulario se envíe
}
</script>

    <footer>
        <p>&copy; 2026 TravelPlus - Todos los derechos reservados</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
