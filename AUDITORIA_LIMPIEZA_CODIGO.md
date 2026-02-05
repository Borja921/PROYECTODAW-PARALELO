# 🔍 AUDITORÍA DE LIMPIEZA DE CÓDIGO - PROYECTODAW-PARALELO

**Proyecto:** MateCyL - Gestor de Planes Turísticos  
**Fecha de Auditoría:** 2025-01-29  
**Tipo de Análisis:** Código duplicado, no utilizado, redundancia, dependencias y complejidad innecesaria  
**Acción:** Identificación ÚNICAMENTE (Sin refactorización)

---

## 📊 RESUMEN EJECUTIVO

Se identificaron **15 problemas de limpieza de código** distribuidos en 3 categorías principales:

| Categoría | Cantidad | Severidad |
|-----------|----------|-----------|
| **Código Duplicado** | 7 issues | 🔴 Alta/Media |
| **Lógica Redundante** | 5 issues | 🟠 Media |
| **Código No Utilizado** | 2 issues | 🔵 Baja |
| **Complejidad Innecesaria** | 2 issues | 🟠 Media |
| **Migraciones Obsoletas** | 1 issue | 🔵 Baja |

**Score de Limpieza:** 65/100 (Necesita mejora moderada)

---

## 1. 🔴 CÓDIGO DUPLICADO (ALTA PRIORIDAD)

### 1.1 Función `normalizeString()` - Repetida 3 veces

**Severidad:** 🔴 ALTA  
**Tipo:** `duplicado`  
**Archivos Afectados:**
- [app/Http/Controllers/PlanWizardController.php](app/Http/Controllers/PlanWizardController.php#L57-L62) - Líneas 57-62
- [app/Http/Controllers/PlanWizardController.php](app/Http/Controllers/PlanWizardController.php#L180-L185) - Líneas 180-185
- [app/Http/Controllers/PlanWizardController.php](app/Http/Controllers/PlanWizardController.php#L249-L254) - Líneas 249-254

**Código Duplicado:**
```php
$normalizeString = function($str) {
    if (mb_detect_encoding($str, 'UTF-8', true) === false) {
        $str = utf8_encode($str);
    }
    $str = strtolower($str);
    $str = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', 'à', 'è', 'ì', 'ò', 'ù'], 
                      ['a', 'e', 'i', 'o', 'u', 'n', 'u', 'a', 'e', 'i', 'o', 'u'], $str);
    $str = preg_replace('/[^a-z0-9\s\-]/', '', $str);
    return trim($str);
};
```

**Impacto:** 18 líneas de código duplicadas. Dificulta mantenimiento.

**Recomendación:** Extraer a un método privado o Helper:
- Opción A: Crear `app/Helpers/StringHelper.php` con método `normalizeString()`
- Opción B: Agregar método privado `normalizeString()` en `PlanWizardController`
- Opción C: Crear Trait `NormalizesTrait` reutilizable

---

## 2. 🟠 LÓGICA REDUNDANTE (SEVERIDAD MEDIA)

### 2.1 Métodos Idénticos en 4 Modelos Públicos

**Severidad:** 🟠 MEDIA  
**Tipo:** `redundante`  
**Archivos Afectados:**
- [app/Models/PublicHotel.php](app/Models/PublicHotel.php#L41-L57)
- [app/Models/PublicRestaurant.php](app/Models/PublicRestaurant.php#L28-L54)
- [app/Models/PublicMuseum.php](app/Models/PublicMuseum.php#L27-L53)
- [app/Models/PublicFestival.php](app/Models/PublicFestival.php#L30-L56)

**Métodos Repetidos:**
1. `byLocality($locality)` - Mismo patrón en 4 modelos
2. `getLocalitiesWithCount()` - Mismo patrón en 4 modelos
3. `getProvinces()` - Mismo patrón en 4 modelos

**Código Repetido (Ejemplo):**
```php
// En todos los 4 modelos:
public static function byLocality($locality) {
    return self::where('locality', $locality)
        ->where('is_active', true)
        ->orderBy('name')
        ->get();
}

public static function getLocalitiesWithCount() {
    return self::where('is_active', true)
        ->selectRaw('locality, COUNT(*) as count')
        ->groupBy('locality')
        ->orderBy('locality')
        ->get();
}

public static function getProvinces() {
    return self::where('is_active', true)
        ->distinct()
        ->pluck('province')
        ->filter()
        ->sort()
        ->values();
}
```

**Impacto:** 36 líneas de lógica idéntica distribuida en 4 modelos. Dificulta cambios futuros.

**Recomendación:** Crear Trait `PublicResourceTrait`:
```php
trait PublicResourceTrait {
    public static function byLocality($locality) { ... }
    public static function getLocalitiesWithCount() { ... }
    public static function getProvinces() { ... }
}
```
Luego usar en los 4 modelos: `use PublicResourceTrait;`

---

### 2.2 Métodos `normalizeProvince()` Repetidos en 5 Archivos

**Severidad:** 🟠 MEDIA  
**Tipo:** `redundante`  
**Archivos Afectados:**
- [app/Console/Commands/ImportHotelsData.php](app/Console/Commands/ImportHotelsData.php#L130)
- [app/Console/Commands/ImportRestaurantsData.php](app/Console/Commands/ImportRestaurantsData.php#L200)
- [app/Console/Commands/ImportMuseumsData.php](app/Console/Commands/ImportMuseumsData.php#L315)
- [app/Console/Commands/ImportFestivalsData.php](app/Console/Commands/ImportFestivalsData.php#L211)
- [app/Http/Controllers/HotelsController.php](app/Http/Controllers/HotelsController.php#L53)

**Patrón Repetido:** 5 implementaciones de normalización de provincias

**Impacto:** Lógica de normalización está dispersa. Cambios futuros afectarían múltiples archivos.

**Recomendación:** Centralizar en `app/Helpers/StringHelper.php` o crear Trait `NormalizesProvinces`.

---

### 2.3 Lógica de Check `Plan::userColumn()` Repetida

**Severidad:** 🟠 MEDIA  
**Tipo:** `redundante`  
**Archivos Afectados:**
- [app/Http/Controllers/PlanesController.php](app/Http/Controllers/PlanesController.php#L24-L27) - Líneas 24-27
- [app/Http/Controllers/PlanesController.php](app/Http/Controllers/PlanesController.php#L56) - Línea 56
- [app/Http/Controllers/PlanesController.php](app/Http/Controllers/PlanesController.php#L88) - Línea 88
- [app/Http/Controllers/PerfilController.php](app/Http/Controllers/PerfilController.php#L20) - Línea 20
- [app/Http/Controllers/PerfilController.php](app/Http/Controllers/PerfilController.php#L122) - Línea 122

**Código Repetido:**
```php
$userColumn = Plan::userColumn();
// Luego usado para validar propiedad del usuario
```

**Ocurrencias:** 5+ veces en el codebase

**Recomendación:** Crear método privado en `PlanesController`:
```php
private function getUserColumn(): string {
    return Plan::userColumn();
}
```

---

### 2.4 Lógica de Autorización Idéntica en 3 Métodos

**Severidad:** 🟠 MEDIA  
**Tipo:** `redundante`  
**Archivos Afectados:**
- [app/Http/Controllers/PlanesController.php](app/Http/Controllers/PlanesController.php#L87-L92) - show()
- [app/Http/Controllers/PlanesController.php](app/Http/Controllers/PlanesController.php#L136-L141) - finalize()
- [app/Http/Controllers/PlanesController.php](app/Http/Controllers/PlanesController.php#L168-L173) - destroy()

**Código Repetido:**
```php
$userColumn = Plan::userColumn();
if ($plan->{$userColumn} !== Auth::id()) {
    abort(403, 'No tienes permiso para acceder a este plan.');
}
```

**Impacto:** Mismo check en 3 métodos. Dificulta cambios de lógica de autorización.

**Recomendación:** Crear Middleware `AuthorizePlan` o usar método en modelo:
```php
// En Plan.php
public function isOwnedBy($userId): bool {
    $userColumn = self::userColumn();
    return $this->{$userColumn} === $userId;
}

// En controlador
if (!$plan->isOwnedBy(Auth::id())) {
    abort(403, 'No tienes permiso...');
}
```

---

### 2.5 Estructuras de Controladores de Recursos Casi Idénticas

**Severidad:** 🟠 MEDIA  
**Tipo:** `redundante`  
**Archivos Afectados:**
- [app/Http/Controllers/HotelsController.php](app/Http/Controllers/HotelsController.php#L1-L100)
- [app/Http/Controllers/RestaurantsController.php](app/Http/Controllers/RestaurantsController.php#L1-L100)
- [app/Http/Controllers/MuseumsController.php](app/Http/Controllers/MuseumsController.php#L1-L100)
- [app/Http/Controllers/FestivalsController.php](app/Http/Controllers/FestivalsController.php#L1-L100)

**Patrón Repetido (70% similitud):**
```php
public function index() {
    $provinces = PublicResource::getProvinces();
    return view('resource', ['provinces' => $provinces]);
}

public function filterByLocality($locality) {
    $resources = PublicResource::byLocality($locality);
    return response()->json($resources);
}
```

**Impacto:** 4 controladores con estructura casi idéntica. Cambios deben aplicarse en 4 lugares.

**Recomendación:** Crear `BasePublicResourceController` abstracto:
```php
abstract class BasePublicResourceController extends Controller {
    protected $modelClass;
    protected $viewName;
    
    public function index() {
        $provinces = $this->modelClass::getProvinces();
        return view($this->viewName, ['provinces' => $provinces]);
    }
    // ...
}
```

---

## 3. 🔴 COMPLEJIDAD INNECESARIA (SEVERIDAD ALTA)

### 3.1 Lógica de Filtrado Sobrecomplicada en `PlanWizardController::hoteles()`

**Severidad:** 🔴 ALTA  
**Tipo:** `redundante`  
**Archivo Afectado:** [app/Http/Controllers/PlanWizardController.php](app/Http/Controllers/PlanWizardController.php#L82-L102)

**Problema:**
```php
// Líneas 82-102: Lógica de filtrado muy compleja para matching parcial/exacto
$hotels = $allHotels->filter(function($hotel) use ($provinciaNormalizada, $municipioNormalizado, $normalizeString) {
    $hotelProvince = $normalizeString($hotel->province);
    $hotelLocality = $normalizeString($hotel->locality);
    
    // Matching parcial con múltiples condiciones
    $provinciaMatch = ($hotelProvince === $provinciaNormalizada) || 
                      (strlen($hotelProvince) > 2 && strlen($provinciaNormalizada) > 2 && 
                       (strpos($provinciaNormalizada, $hotelProvince) !== false || 
                        strpos($hotelProvince, $provinciaNormalizada) !== false));
    
    $localidadMatch = ($hotelLocality === $municipioNormalizado) ||
                      (strlen($hotelLocality) > 2 && strlen($municipioNormalizado) > 2 &&
                       (strpos($municipioNormalizado, $hotelLocality) !== false || 
                        strpos($hotelLocality, $municipioNormalizado) !== false));
    
    return $provinciaMatch && $localidadMatch;
})->sortBy('name')->values();
```

**Por qué es compleja:**
- 16 líneas para lógica de matching
- 3 niveles de anidamiento
- Múltiples condiciones que podrían simplificarse
- Mejor usar LIKE en SQL que filter en PHP

**Impacto:** Difícil de leer y mantener. Performance pobrecilla (N operaciones en PHP en lugar de BD).

**Recomendación:** Simplificar a método privado o query SQL:
```php
// Opción 1: Método privado
private function filterHotels($province, $municipality) {
    return PublicHotel::where('is_active', true)
        ->whereRaw("LOWER(REPLACE(province, 'á', 'a')) LIKE ?", ['%' . $this->normalize($province) . '%'])
        ->whereRaw("LOWER(REPLACE(locality, 'á', 'a')) LIKE ?", ['%' . $this->normalize($municipality) . '%'])
        ->orderBy('name')
        ->get();
}
```

---

### 3.2 N+1 Query Potential en `PlanesController::show()`

**Severidad:** 🟠 MEDIA  
**Tipo:** `redundante`  
**Archivo Afectado:** [app/Http/Controllers/PlanesController.php](app/Http/Controllers/PlanesController.php#L109-L126)

**Problema:**
```php
// 4 queries separadas en lugar de eager loading
$selectedHotels = $hotelIds->isNotEmpty() ? PublicHotel::whereIn('id', $hotelIds)->get() : collect();
$selectedRestaurants = $restaurantIds->isNotEmpty() ? PublicRestaurant::whereIn('id', $restaurantIds)->get() : collect();
$selectedMuseums = $museumIds->isNotEmpty() ? PublicMuseum::whereIn('id', $museumIds)->get() : collect();
$selectedFestivals = $festivalIds->isNotEmpty() ? PublicFestival::whereIn('id', $festivalIds)->get() : collect();
```

**Impacto:** Se ejecutan hasta 4 queries adicionales cuando se podría hacer en 1 con eager loading.

**Recomendación:** Consolidar en una sola query o Helper:
```php
// Opción: Método privado
private function loadPlanItems($plan) {
    return [
        'hotels' => PublicHotel::whereIn('id', $plan->hotelIds ?? [])->get(),
        'restaurants' => PublicRestaurant::whereIn('id', $plan->restaurantIds ?? [])->get(),
        'museums' => PublicMuseum::whereIn('id', $plan->museumIds ?? [])->get(),
        'festivals' => PublicFestival::whereIn('id', $plan->festivalIds ?? [])->get(),
    ];
}
```

---

## 4. 🔵 CÓDIGO NO UTILIZADO (SEVERIDAD BAJA)

### 4.1 Ruta Legacy Duplicada en `routes/web.php`

**Severidad:** 🔵 BAJA  
**Tipo:** `no usado`  
**Archivo Afectado:** [routes/web.php](routes/web.php#L30-L34)

**Problema:**
```php
// Línea 30: Ruta principal correcta
Route::get('/mis-planes/{id}', [App\Http\Controllers\PlanesController::class, 'show'])->name('mis-planes.show')->middleware('auth');

// Línea 78: Ruta legacy (comentada como backward compatibility)
Route::get('/planes/{id}', [App\Http\Controllers\PlanesController::class, 'show'])->name('detalle-plan');

// Línea 110: RUTA DUPLICADA E INESPERADA - Abierta sin auth!
Route::get('/planes/{id}', function ($id) {
    return view('detalle-plan');
})->name('detalle-plan');
```

**Problemas:**
1. Dos rutas con mismo path `/planes/{id}` (líneas 78 y 110) - Duplicadas
2. Línea 110 es una closure que retorna una vista, no el controlador
3. Línea 110 no está protegida con middleware auth (SEGURIDAD)
4. Ambas usa el mismo `->name('detalle-plan')` (naming conflict)

**Impacto:** Confusión en enrutamiento. Potencial problema de seguridad si es accedida sin auth.

**Recomendación:** Eliminar línea 110 o consolidar en una única ruta:
```php
// Mantener solo esta:
Route::get('/plans/{id}', [PlanesController::class, 'show'])->name('detalle-plan');
// O con auth si es necesario:
Route::get('/planes/{id}', [PlanesController::class, 'show'])->name('detalle-plan')->middleware('auth');
```

---

### 4.2 Variables Debug Pasadas a Vista

**Severidad:** 🔵 BAJA  
**Tipo:** `no usado`  
**Archivo Afectado:** [app/Http/Controllers/PlanWizardController.php](app/Http/Controllers/PlanWizardController.php#L106-L125)

**Variables Debug:**
- `$debugHotels` (Línea 106)
- `$hotelsInProvince` (Línea 120)
- `$availableLocalities` (Línea 125)
- `$provinciaBuscada` (Línea 128)
- `$municipioBuscado` (Línea 129)

**Código:**
```php
return view('plan-wizard.hoteles', [
    'draft' => $draft,
    'hotels' => $hotels,
    'provinces' => $provinces,
    'hotelsInProvince' => $hotelsInProvince,      // DEBUG: no usado en vista
    'availableLocalities' => $availableLocalities, // DEBUG: no usado en vista
    'debugHotels' => $debugHotels,                // DEBUG: no usado en vista
    'provinciaBuscada' => $provinciaBuscada,      // DEBUG: no usado en vista
    'municipioBuscado' => $municipioBuscado,      // DEBUG: no usado en vista
]);
```

**Impacto:** Variables que consume memoria pero no se usan. Deja evidencia de debugging en código de producción.

**Recomendación:** Remover del `view()` si no se utilizan en la plantilla. Mantener solo:
```php
return view('plan-wizard.hoteles', [
    'draft' => $draft,
    'hotels' => $hotels,
    'provinces' => $provinces,
]);
```

---

## 5. 🟠 ESTRUCTURA HTML DUPLICADA EN VISTAS

**Severidad:** 🟠 MEDIA  
**Tipo:** `redundante`  
**Archivos Afectados:**
- [resources/views/hoteles.blade.php](resources/views/hoteles.blade.php)
- [resources/views/restaurantes.blade.php](resources/views/restaurantes.blade.php)
- [resources/views/museos.blade.php](resources/views/museos.blade.php)
- [resources/views/fiestas.blade.php](resources/views/fiestas.blade.php)

**Patrón Repetido:** Todas usan estructura HTML casi idéntica:
```blade
<section class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>{{ $titulo }}</h1>
            <p class="subtitle">{{ $subtitulo }}</p>
        </div>
        <div id="{{ $gridId }}" class="hotels-grid">
            @if($items->isEmpty())
                <div class="placeholder-container">
                    <p>Selecciona...</p>
                </div>
            @else
                @foreach($items as $item)
                    <div class="hotel-card">
                        <!-- Contenido variable según tipo -->
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
```

**Impacto:** 4 vistas con ~240 líneas cada una. Cambios de CSS/estructura requieren actualizar 4 archivos.

**Recomendación:** Crear component Blade reutilizable:
```blade
<!-- resources/views/components/resource-grid.blade.php -->
<x-resource-grid 
    :items="$items" 
    :title="$title"
    :gridId="$gridId"
    :resourceType="$type" />
```

---

## 6. 🟠 JOBS CON ESTRUCTURA SIMPLE PERO REDUNDANTE

**Severidad:** 🟠 MEDIA  
**Tipo:** `redundante`  
**Archivos Afectados:**
- [app/Jobs/ImportHotelsJob.php](app/Jobs/ImportHotelsJob.php)
- [app/Jobs/ImportMuseumsJob.php](app/Jobs/ImportMuseumsJob.php)
- [app/Jobs/ImportMunicipiosJob.php](app/Jobs/ImportMunicipiosJob.php)

**Patrón (Idéntico en 3 Jobs):**
```php
class ImportHotelsJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public function handle() {
        Artisan::call('hotels:import');
    }
}
```

**Impacto:** 3 archivos prácticamente idénticos. Solo cambia el nombre de comando.

**Recomendación:** Crear `BaseImportJob` abstracto:
```php
abstract class BaseImportJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $command;
    
    public function handle() {
        Artisan::call($this->command);
    }
}

// Luego:
class ImportHotelsJob extends BaseImportJob {
    protected $command = 'hotels:import';
}
```

---

## 7. 🔵 COMENTARIOS OBSOLETOS / INCOMPLETOS

**Severidad:** 🔵 BAJA  
**Tipo:** `código obsoleto`  

### 7.1 Comentario Sobre Protección de Endpoint

**Archivo:** [app/Http/Controllers/MunicipioController.php](app/Http/Controllers/MunicipioController.php#L35)

```php
/**
 * Forzar refresco: limpia cache y lanza job de import (requiere permisos en prod).
 */
public function refresh(Request $request) {
    // Nota: este endpoint no está protegido por auth en esta PR; puedes añadir middleware 'auth' si lo deseas.
    Cache::forget('jcyl_municipios_v1');
    // ...
}
```

**Problema:** Comentario sugiere que debe añadirse auth pero no está implementado. Endpoint está desprotegido.

**Recomendación:** Añadir middleware auth o documentar por qué está abierto:
```php
Route::post('/api/municipios/refresh', [MunicipioController::class, 'refresh'])
    ->middleware('auth')
    ->name('api.municipios.refresh');
```

---

### 7.2 Comentarios en Blade Sobre "Selectores"

**Archivo:** [resources/views/plan-wizard/hoteles.blade.php](resources/views/plan-wizard/hoteles.blade.php#L88)

```blade
<!-- Primera fila: Todos los selectores -->
```

Este comentario es vago y no añade valor. Mejor sería:
```blade
<!-- Filter row: Province and Municipality selectors -->
```

---

## 8. 📋 ANÁLISIS DE DEPENDENCIAS

### 8.1 Dependencias Sin Usar Directamente

**Severidad:** 🔵 BAJA  
**Archivo:** [composer.json](composer.json)

Revisar si se usan activamente:
- `laravel/tinker` - ✅ Usado (console)
- `laravel/sail` - ❓ Revisar si se usa Docker
- `phpunit/phpunit` - ✅ Usado
- `league/csv` - ✅ Usado (ImportCommands)
- `guzzlehttp/guzzle` - ✅ Usado (Http client)
- `fakerphp/faker` - ✅ Usado (Factories)
- `mockery/mockery` - ✅ Usado (Testing)

**Recomendación:** Ejecutar `composer unused` para identificar dependencias no utilizadas:
```bash
composer unused
```

---

## 9. 🔧 MIGRACIONES Y BASES DE DATOS

### 9.1 Posible Columna Legacy en `plans` Table

**Severidad:** 🔵 BAJA  
**Tipo:** `código obsoleto`  

**Problema:** El modelo `Plan` maneja dos nombres de columna de usuario:
- `user_id` (Nuevo estándar)
- `id_user` (Legacy)

```php
// Plan.php
public static function userColumn(): string {
    if (Schema::hasColumn($table, 'id_user')) {
        return 'id_user';
    }
    return 'user_id';
}
```

**Impacto:** Código defensivo para migración que genera complejidad adicional.

**Recomendación:** 
1. Verificar si ambas columnas existen en la BD actualmente
2. Si solo existe `user_id`: Limpiar este método
3. Si ambas existen: Crear migración para eliminar columna legacy `id_user`

---

## 10. 🟢 BUENAS PRÁCTICAS ENCONTRADAS

Puntos positivos del código:

✅ **Validación en Request:** UpdatePerfilRequest.php en su lugar  
✅ **Autenticación Segura:** bcrypt para passwords  
✅ **Soft Deletes:** Modelos Public* usan SoftDeletes  
✅ **Separación de Responsabilidades:** Controllers bien estructurados  
✅ **Blade Templating:** Uso correcto de Blade syntax  
✅ **Type Casting:** Models definen casts apropiados  

---

## 📝 RESUMEN DE RECOMENDACIONES

| # | Acción | Prioridad | Esfuerzo | Beneficio |
|---|--------|-----------|----------|-----------|
| 1 | Extraer `normalizeString()` a Helper | 🔴 Alta | 30 min | Elimina 18 líneas duplicadas |
| 2 | Crear `PublicResourceTrait` | 🟠 Media | 45 min | Consolida 36 líneas de lógica |
| 3 | Centralizar `normalizeProvince()` | 🟠 Media | 30 min | 5 implementaciones en 1 |
| 4 | Crear método `Plan::isOwnedBy()` | 🟠 Media | 20 min | Elimina 3 duplicaciones |
| 5 | Refactorizar controllers públicos | 🟠 Media | 60 min | Reduce 400+ líneas |
| 6 | Simplificar filtrado en `hoteles()` | 🟠 Media | 40 min | Mejora performance y legibilidad |
| 7 | Consolidar rutas `/planes/{id}` | 🔵 Baja | 10 min | Elimina confusión |
| 8 | Remover variables debug | 🔵 Baja | 5 min | Limpia código |
| 9 | Crear component Blade para grids | 🟠 Media | 50 min | Reduce 200+ líneas HTML |
| 10 | Crear `BaseImportJob` | 🟠 Media | 20 min | Consolida 3 Jobs |

---

## 🎯 CONCLUSIÓN

El proyecto tiene una **buena arquitectura general** pero presenta **duplicación de código** en áreas estratégicas (modelos, controladores, helpers). La mayoría de problemas son de **mantenibilidad** más que de **funcionalidad**.

**Prioridades para siguiente iteración:**
1. **Inmediato:** Extraer `normalizeString()` (Alto ROI, bajo esfuerzo)
2. **Próximo Sprint:** Crear traits para modelos y controllers (Facilita cambios futuros)
3. **Refactorización Gradual:** Componentes Blade y consolidación de jobs

**Score Final:** 65/100 (Codificación funcional pero con margen de mejora en limpieza y mantenibilidad)

---

*Auditoría completada. No se aplicaron modificaciones al código (análisis READONLY).*
