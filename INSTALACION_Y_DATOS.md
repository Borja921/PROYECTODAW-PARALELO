# TravelPlus - Guía de Configuración e Importación de Datos

## Descripción del Proyecto

TravelPlus es una aplicación web de planificación de viajes construida con Laravel, que permite a los usuarios explorar destinos, crear planes de viaje personalizados y consultar información de alojamientos hoteleros reales de la comunidad autónoma de Castilla y León.

## Estructura del Proyecto

```
PROYECTODAW-PARALELO/
├── app/
│   ├── Http/Controllers/
│   │   └── HotelsController.php       (Controlador para gestionar la vista de hoteles)
│   ├── Models/
│   │   ├── User.php
│   │   └── PublicHotel.php             (Modelo para hoteles públicos)
│   └── Console/Commands/
│       └── ImportHotelsData.php        (Comando para importar datos CSV)
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 2025_01_28_000003_create_destinations_table.php
│       ├── 2025_01_28_000004_create_hotels_table.php
│       ├── 2025_01_28_000005_create_restaurants_table.php
│       ├── 2025_01_28_000006_create_attractions_table.php
│       ├── 2025_01_28_000007_create_travel_plans_table.php
│       ├── 2025_01_28_000008_create_plan_items_table.php
│       ├── 2025_01_28_000009_create_reviews_table.php
│       ├── 2025_01_28_000010_create_contacts_table.php
│       └── 2025_01_28_000011_create_public_hotels_table.php (Tabla para hoteles públicos)
├── public/
│   ├── css/
│   │   └── styles.css                  (Estilos completos con diseño minimalista)
│   └── js/
│       └── script.js                   (Funcionalidades JavaScript interactivas)
├── resources/
│   └── views/
│       ├── index.blade.php
│       ├── destinos.blade.php
│       ├── hoteles.blade.php           (Vista de hoteles con filtrado por localidad)
│       ├── planes.blade.php
│       ├── mis-planes.blade.php
│       ├── perfil.blade.php
│       ├── contacto.blade.php
│       ├── preguntas-frecuentes.blade.php
│       ├── registro.blade.php
│       └── detalle-plan.blade.php
└── routes/
    └── web.php                          (Rutas de la aplicación)
```

## Pasos de Instalación y Configuración

### 1. Instalación de Dependencias

Si no has instalado las dependencias de PHP, ejecuta:

```bash
cd c:\laragon\www\PROYECTODAW-PARALELO
composer install
```

**Nota**: Asegúrate de que `League\Csv` está instalado. Si no, instálalo con:
```bash
composer require league/csv
```

### 2. Configurar la Base de Datos

Verifica que tu archivo `.env` contiene la configuración correcta:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyectoviajesprueba
DB_USERNAME=root
DB_PASSWORD=
```

Crea la base de datos si no existe:
```bash
mysql -u root -p
> CREATE DATABASE proyectoviajesprueba;
> EXIT;
```

### 3. Ejecutar las Migraciones

Para crear todas las tablas en la base de datos:

```bash
php artisan migrate
```

Esto creará las siguientes tablas:
- **users** - Información de usuarios
- **destinations** - Destinos turísticos
- **hotels** - Hoteles vinculados a destinos
- **restaurants** - Restaurantes
- **attractions** - Atracciones
- **travel_plans** - Planes de viaje creados por usuarios
- **plan_items** - Items individuales de un plan
- **reviews** - Reseñas de usuarios
- **contacts** - Mensajes de contacto
- **public_hotels** - Datos públicos de hoteles (Castilla y León)

### 4. Importar Datos de Hoteles Públicos

Ejecuta el comando Artisan para descargar e importar datos reales de la API de datos abiertos de Castilla y León:

```bash
php artisan hotels:import
```

Este comando:
- Descarga el CSV desde: https://opendata.jcyl.es/ficheros/cct/retu/alojamientoshoteleros.csv
- Procesa los datos con la librería League\Csv
- Importa los hoteles a la tabla `public_hotels`
- Evita duplicados usando `updateOrCreate()` basado en nombre + localidad
- Muestra un informe de progreso y errores

**Salida esperada**:
```
Iniciando importación de hoteles...
Registros importados: 245
Errores encontrados: 0
✓ ¡Importación completada exitosamente!
```

### 5. Iniciar el Servidor

Inicia el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

Por defecto se ejecutará en: `http://localhost:8000`

## Rutas Disponibles

| Ruta | Nombre | Descripción |
|------|--------|-------------|
| `/` | index | Página de inicio |
| `/destinos` | destinos | Explorador de destinos |
| `/hoteles` | hoteles | Lista de hoteles con filtrado por localidad |
| `/planes` | planes | Crear nuevo plan de viaje |
| `/mis-planes` | mis-planes | Dashboard de planes del usuario |
| `/perfil` | perfil | Perfil de usuario |
| `/contacto` | contacto | Formulario de contacto |
| `/preguntas-frecuentes` | preguntas-frecuentes | Preguntas frecuentes |
| `/registro` | registro | Formulario de registro |
| `/planes/{id}` | detalle-plan | Detalles de un plan específico |
| `/hoteles/{id}` | hotels.show | Detalles de un hotel específico |
| `/hoteles/filtrar/{locality}` | hotels.filter | API para filtrado AJAX de hoteles |

## Vista de Hoteles

La página `/hoteles` incluye:

- **Selector de Localidades**: Dropdown que muestra todas las localidades disponibles con el conteo de hoteles
- **Filtrado Dinámico**: Los hoteles se filtran al seleccionar una localidad
- **Tarjetas de Hotel** que muestran:
  - Nombre y localidad del hotel
  - Clasificación (★★★★★)
  - Dirección completa y código postal
  - Número de habitaciones
  - Teléfono y correo de contacto
  - Sitio web con enlace de reserva
  - Calificación y número de reseñas
  - Descripción del establecimiento

## Estilo y Diseño

La aplicación utiliza una paleta de colores **minimalista quebrada**:
- **Primary**: #8B7B7B (Marrón
- **Secondary**: #A89B9B (Marrón claro)
- **Accent**: #9D8B7E (Accent)
- **Light**: #D4CCC4 (Claro)
- **Lighter**: #E8E3DE (Muy claro)

Características visuales:
- Gradientes suaves (135deg)
- Animaciones elegantes (fadeInDown, fadeInUp)
- Diseño responsive (768px y 480px breakpoints)
- Tarjetas con efecto hover (translateY)
- Tipografía limpia y legible

## Desarrollo Posterior

Cosas que puedes agregar:

1. **Autenticación de Usuarios**: Implementar login/logout
2. **Sistema de Reservas**: Integración con APIs de reserva
3. **Calificaciones Reales**: Integrar reviews de usuarios reales
4. **Mapas**: Mostrar ubicación de hoteles en mapas
5. **Búsqueda Avanzada**: Filtros por precio, amenidades, etc.
6. **Notificaciones**: Alertas sobre cambios de precios
7. **Exportar Plans**: Descargar planes en PDF

## Troubleshooting

### Error: "Class 'League\Csv\Reader' not found"
Solución: Instala league/csv
```bash
composer require league/csv
```

### Error: "Table 'public_hotels' doesn't exist"
Solución: Ejecuta las migraciones
```bash
php artisan migrate
```

### El import de hoteles falla
Solución: Comprueba la conexión a internet y que la URL del CSV está accesible:
```bash
php artisan hotels:import --verbose
```

### Los hoteles no se muestran en el filtro
Solución: Verifica que la importación completó exitosamente
```bash
php artisan tinker
PublicHotel::count(); // Debería devolver el número de hoteles importados
```

## Autor y Fecha

Proyecto creado: Enero 2025
Última actualización: Enero 2025

---

Para más información sobre Laravel, visita: [https://laravel.com](https://laravel.com)
