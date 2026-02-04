// ============================================
// MAPA Y CLIMA PARA PLANES
// ============================================

let map = null;
let marker = null;

// Normalizar texto para comparar (sin tildes, minúsculas)
function normalizeKey(value) {
    return (value || '')
        .toString()
        .trim()
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '');
}

// Coordenadas de las provincias de Castilla y León (claves normalizadas)
const provinciasCoordenadas = {
    'avila': [40.6561, -4.6818],
    'burgos': [42.3439, -3.6969],
    'leon': [42.5987, -5.5671],
    'palencia': [42.0097, -4.5288],
    'salamanca': [40.9651, -5.6640],
    'segovia': [40.9429, -4.1088],
    'soria': [41.7665, -2.4790],
    'valladolid': [41.6523, -4.7245],
    'zamora': [41.5034, -5.7467]
};

// Cache de coordenadas de municipios obtenidas dinámicamente
const municipiosCoordenadas = {};

// Función para obtener coordenadas de un municipio usando Nominatim (OpenStreetMap)
async function getCoordinatesForMunicipio(municipio, provincia) {
    const cacheKey = `${normalizeKey(provincia)}_${normalizeKey(municipio)}`;
    
    // Si ya tenemos las coordenadas en cache, retornarlas
    if (municipiosCoordenadas[cacheKey]) {
        return municipiosCoordenadas[cacheKey];
    }
    
    try {
        // Buscar usando Nominatim API
        const query = `${municipio}, ${provincia}, España`;
        const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1&countrycodes=es`;
        
        console.log('Buscando coordenadas para:', query);
        
        const response = await fetch(url, {
            headers: {
                'User-Agent': 'MateCyL App'
            }
        });
        
        if (!response.ok) {
            throw new Error('Error en la búsqueda de coordenadas');
        }
        
        const data = await response.json();
        
        if (data && data.length > 0) {
            const coords = [parseFloat(data[0].lat), parseFloat(data[0].lon)];
            municipiosCoordenadas[cacheKey] = coords;
            console.log('Coordenadas encontradas:', municipio, coords);
            return coords;
        }
        
        console.warn('No se encontraron coordenadas para:', municipio);
        return null;
        
    } catch (error) {
        console.error('Error obteniendo coordenadas:', error);
        return null;
    }
}

// API Key de OpenWeatherMap - Esta es una clave demo, deberías usar la tuya propia
const WEATHER_API_KEY = 'f8c5e1a8e8f8e8f8e8f8e8f8e8f8e8f8'; // Reemplaza con tu API key de openweathermap.org

// Inicializar mapa cuando se seleccione provincia y municipio
async function initializeMap(provincia, municipio) {
    console.log('Inicializando mapa:', provincia, municipio);
    const mapContainer = document.getElementById('mapContainer');
    const mapDiv = document.getElementById('map');
    
    if (!provincia) {
        mapContainer.style.display = 'none';
        return;
    }
    
    mapContainer.style.display = 'block';
    
    const provinciaKey = normalizeKey(provincia);
    let coords = provinciasCoordenadas[provinciaKey] || [41.6523, -4.7245];
    let zoomLevel = 9;
    let locationName = provincia;
    
    // Si hay municipio seleccionado, obtener sus coordenadas
    if (municipio) {
        const municipioCoords = await getCoordinatesForMunicipio(municipio, provincia);
        if (municipioCoords) {
            coords = municipioCoords;
            zoomLevel = 13;
            locationName = municipio;
            console.log('Usando coordenadas del municipio:', municipio, coords);
        } else {
            console.log('Usando coordenadas de la provincia como fallback:', provincia, coords);
        }
    } else {
        console.log('Usando coordenadas de la provincia:', provincia, coords);
    }
    
    // Si el mapa no existe, crearlo
    if (!map) {
        console.log('Creando nuevo mapa');
        map = L.map('map').setView(coords, zoomLevel);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);
        
        // Configurar icono por defecto de Leaflet (fix para problemas de carga)
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png'
        });
    } else {
        // Si ya existe, actualizar vista con animación
        console.log('Actualizando vista del mapa a:', locationName, coords, 'zoom:', zoomLevel);
        map.setView(coords, zoomLevel, {
            animate: true,
            duration: 1
        });
    }
    
    // Eliminar marcador anterior si existe
    if (marker) {
        map.removeLayer(marker);
    }
    
    // Agregar nuevo marcador
    marker = L.marker(coords).addTo(map);
    const popupText = municipio ? `<b>${municipio}</b><br><small>${provincia}</small>` : `<b>${provincia}</b>`;
    marker.bindPopup(popupText).openPopup();
    console.log('Marcador agregado en:', coords);
    
    // Forzar actualización del tamaño del mapa
    setTimeout(() => {
        if (map) {
            map.invalidateSize();
        }
    }, 200);
}

// Obtener pronóstico del tiempo
async function loadWeather(provincia, startDate, endDate) {
    console.log('Cargando clima para:', provincia, startDate, endDate);
    const weatherContainer = document.getElementById('weatherContainer');
    const weatherInfo = document.getElementById('weatherInfo');
    
    if (!provincia || !startDate) {
        weatherContainer.style.display = 'none';
        return;
    }
    
    weatherContainer.style.display = 'block';
    weatherInfo.innerHTML = `
        <div style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">⏳</div>
            <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Cargando información del clima...</p>
        </div>
    `;
    
    try {
        const coords = provinciasCoordenadas[provincia] || [41.6523, -4.7245];
        const lat = coords[0];
        const lon = coords[1];
        
        console.log('Coordenadas para clima:', lat, lon);
        
        // Calcular días hasta el viaje
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const tripDate = new Date(startDate);
        tripDate.setHours(0, 0, 0, 0);
        const daysUntilTrip = Math.ceil((tripDate - today) / (1000 * 60 * 60 * 24));
        
        console.log('Días hasta el viaje:', daysUntilTrip);
        
        // Usar Open-Meteo API (gratuita, sin necesidad de API key)
        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=temperature_2m_max,temperature_2m_min,weathercode&timezone=Europe/Madrid&start_date=${startDate}&end_date=${endDate}`;
        
        console.log('URL de la API:', url);
        
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Datos del clima:', data);
        
        // Verificar que tenemos datos
        if (!data.daily || !data.daily.time || data.daily.time.length === 0) {
            throw new Error('No hay datos de pronóstico disponibles');
        }
        
        // Mostrar pronóstico por día
        let forecastHTML = `
            <div style="text-align: center; margin-bottom: 1rem;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.4rem;">Pronóstico para tu viaje</h3>
                <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">${provincia}</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem;">
        `;
        
        // Mostrar hasta 7 días de pronóstico
        const maxDays = Math.min(data.daily.time.length, 7);
        for (let i = 0; i < maxDays; i++) {
            const date = new Date(data.daily.time[i]);
            const dateStr = date.toLocaleDateString('es-ES', { 
                weekday: 'short', 
                day: 'numeric', 
                month: 'short' 
            });
            const tempMax = Math.round(data.daily.temperature_2m_max[i]);
            const tempMin = Math.round(data.daily.temperature_2m_min[i]);
            const weatherCode = data.daily.weathercode[i];
            const weatherIcon = getWeatherIconFromCode(weatherCode);
            const weatherDesc = getWeatherDescription(weatherCode);
            
            forecastHTML += `
                <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 8px; text-align: center;">
                    <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; font-weight: 600;">${dateStr}</p>
                    <div style="font-size: 2rem; margin: 0.5rem 0;">${weatherIcon}</div>
                    <p style="margin: 0.5rem 0 0 0; font-size: 1.3rem; font-weight: bold;">${tempMax}°</p>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.8;">${tempMin}°</p>
                    <p style="margin: 0.3rem 0 0 0; font-size: 0.8rem; opacity: 0.9;">${weatherDesc}</p>
                </div>
            `;
        }
        
        forecastHTML += '</div>';
        weatherInfo.innerHTML = forecastHTML;
        
    } catch (error) {
        console.error('Error al cargar clima:', error);
        weatherInfo.innerHTML = `
            <div style="text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🌍</div>
                <p style="margin: 0; font-size: 0.9rem;">No se pudo cargar el pronóstico del tiempo</p>
                <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; opacity: 0.8;">${error.message}</p>
            </div>
        `;
    }
}

// Convertir código meteorológico WMO a icono emoji
function getWeatherIconFromCode(code) {
    const weatherIcons = {
        0: '☀️',   // Clear sky
        1: '🌤️',  // Mainly clear
        2: '⛅',   // Partly cloudy
        3: '☁️',   // Overcast
        45: '🌫️', // Foggy
        48: '🌫️', // Depositing rime fog
        51: '🌦️', // Drizzle light
        53: '🌦️', // Drizzle moderate
        55: '🌧️', // Drizzle dense
        61: '🌧️', // Rain slight
        63: '🌧️', // Rain moderate
        65: '🌧️', // Rain heavy
        71: '🌨️', // Snow fall slight
        73: '🌨️', // Snow fall moderate
        75: '❄️',  // Snow fall heavy
        77: '❄️',  // Snow grains
        80: '🌦️', // Rain showers slight
        81: '🌧️', // Rain showers moderate
        82: '🌧️', // Rain showers violent
        85: '🌨️', // Snow showers slight
        86: '❄️',  // Snow showers heavy
        95: '⛈️',  // Thunderstorm
        96: '⛈️',  // Thunderstorm with hail
        99: '⛈️'   // Thunderstorm with heavy hail
    };
    return weatherIcons[code] || '🌤️';
}

// Obtener descripción del clima desde código WMO
function getWeatherDescription(code) {
    const descriptions = {
        0: 'Despejado',
        1: 'Mayormente despejado',
        2: 'Parcialmente nublado',
        3: 'Nublado',
        45: 'Niebla',
        48: 'Niebla depositante',
        51: 'Llovizna ligera',
        53: 'Llovizna moderada',
        55: 'Llovizna intensa',
        61: 'Lluvia ligera',
        63: 'Lluvia moderada',
        65: 'Lluvia intensa',
        71: 'Nieve ligera',
        73: 'Nieve moderada',
        75: 'Nieve intensa',
        77: 'Granizo',
        80: 'Chubascos ligeros',
        81: 'Chubascos moderados',
        82: 'Chubascos intensos',
        85: 'Nevadas ligeras',
        86: 'Nevadas intensas',
        95: 'Tormenta',
        96: 'Tormenta con granizo',
        99: 'Tormenta fuerte'
    };
    return descriptions[code] || 'Variable';
}

// Escuchar cambios en provincia, municipio y fechas
document.addEventListener('DOMContentLoaded', function() {
    const provinciaSelect = document.getElementById('provincia');
    const municipioSelect = document.getElementById('municipio');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    function updateMapAndWeather() {
        const provincia = provinciaSelect.value;
        const municipio = municipioSelect.value || '';
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        
        if (provincia) {
            initializeMap(provincia, municipio);
        }
        
        if (provincia && startDate) {
            loadWeather(provincia, startDate, endDate);
        }
    }
    
    // Escuchar cambios
    if (provinciaSelect) {
        provinciaSelect.addEventListener('change', updateMapAndWeather);
    }
    
    if (municipioSelect) {
        municipioSelect.addEventListener('change', updateMapAndWeather);
    }
    
    if (startDateInput) {
        startDateInput.addEventListener('change', updateMapAndWeather);
    }
    
    if (endDateInput) {
        endDateInput.addEventListener('change', updateMapAndWeather);
    }
});
