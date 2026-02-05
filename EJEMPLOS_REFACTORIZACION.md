# 💡 EJEMPLOS DE REFACTORIZACIÓN - PROYECTODAW-PARALELO

Este documento proporciona ejemplos concretos de cómo resolver cada problema de limpieza de código identificado.

---

## 1️⃣ EXTRAER normalizeString() A HELPER

### ❌ PROBLEMA ACTUAL (3 duplicaciones)
```php
// En PlanWizardController::hoteles() línea 57
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

// ... LUEGO SE REPITE EN restaurantes() línea 180
// ... Y NUEVAMENTE EN museos() línea 249
```

### ✅ SOLUCIÓN: Crear Helper

**Opción A: Helper Function** (`app/Helpers/StringHelper.php`)
```php
<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Normalizar string: quitar tildes, caracteres especiales y corruptos
     * Útil para matching de búsquedas entre UTF-8 y ASCII
     */
    public static function normalize(string $str): string
    {
        // Arreglar encoding corrupto
        if (mb_detect_encoding($str, 'UTF-8', true) === false) {
            $str = utf8_encode($str);
        }
        
        // Convertir a minúsculas
        $str = strtolower($str);
        
        // Eliminar tildes y acentos
        $str = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', 'à', 'è', 'ì', 'ò', 'ù'],
            ['a', 'e', 'i', 'o', 'u', 'n', 'u', 'a', 'e', 'i', 'o', 'u'],
            $str
        );
        
        // Eliminar caracteres no alfanuméricos (excepto espacios y guiones)
        $str = preg_replace('/[^a-z0-9\s\-]/', '', $str);
        
        return trim($str);
    }
}
```

**Uso en Controller:**
```php
<?php
namespace App\Http\Controllers;

use App\Helpers\StringHelper;

class PlanWizardController extends Controller
{
    public function hoteles(Request $request)
    {
        $provinciaNormalizada = StringHelper::normalize($draft['provincia']);
        $municipioNormalizado = StringHelper::normalize($draft['municipio']);
        
        // ... resto del código sin la función anónima
    }
    
    public function restaurantes(Request $request)
    {
        $name = StringHelper::normalize($input);
        // ... más código
    }
}
```

**Registrar en `app/Providers/AppServiceProvider.php` (si usas alias global):**
```php
use Illuminate\Support\Facades\Blade;

public function boot()
{
    if (!function_exists('normalize')) {
        function normalize(string $str): string {
            return \App\Helpers\StringHelper::normalize($str);
        }
    }
}
```

Luego usar directamente:
```php
$normalized = normalize($value);
```

---

## 2️⃣ CREAR PublicResourceTrait

### ❌ PROBLEMA ACTUAL (12 duplicaciones en 4 modelos)
```php
// En PublicHotel.php línea 41
public static function byLocality($locality)
{
    return self::where('locality', $locality)
        ->where('is_active', true)
        ->orderBy('name')
        ->get();
}

// En PublicRestaurant.php línea 28 - IDÉNTICO
// En PublicMuseum.php línea 27 - IDÉNTICO
// En PublicFestival.php línea 30 - CON PEQUEÑA VARIACIÓN
```

### ✅ SOLUCIÓN: Crear Trait

**Archivo: `app/Models/Traits/PublicResourceTrait.php`**
```php
<?php

namespace App\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

trait PublicResourceTrait
{
    /**
     * Obtener recursos por localidad
     * Puede ser sobrescrito en modelos si necesitan lógica especial
     */
    public static function byLocality(string $locality): EloquentCollection
    {
        return self::where('locality', $locality)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Obtener localidades disponibles con conteo de recursos
     */
    public static function getLocalitiesWithCount(): EloquentCollection
    {
        return self::where('is_active', true)
            ->selectRaw('locality, COUNT(*) as count')
            ->groupBy('locality')
            ->orderBy('locality')
            ->get();
    }

    /**
     * Obtener todas las provincias disponibles
     */
    public static function getProvinces(): Collection
    {
        return self::where('is_active', true)
            ->distinct()
            ->pluck('province')
            ->filter()
            ->sort()
            ->values();
    }

    /**
     * Scope para recursos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para búsqueda por nombre
     */
    public function scopeSearchByName($query, string $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%");
    }
}
```

**Uso en Modelos:**
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\PublicResourceTrait;  // ← AGREGAR

class PublicHotel extends Model
{
    use SoftDeletes;
    use PublicResourceTrait;  // ← AGREGAR
    
    protected $table = 'public_hotels';
    // ... resto de propiedades
}

// IDÉNTICO en: PublicRestaurant, PublicMuseum, PublicFestival
```

**Resultado:**
- De 4 archivos con 36 líneas duplicadas → 1 Trait de 40 líneas
- Cambios futuros en lógica → Actualizar 1 archivo
- Fácil de extender con nuevos scopes

---

## 3️⃣ CENTRALIZAR normalizeProvince()

### ❌ PROBLEMA ACTUAL (5 implementaciones)
```php
// En ImportHotelsData.php línea 130
private function normalizeProvince(string $province): string
{
    $province = strtolower($province);
    $province = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], 
                           ['a', 'e', 'i', 'o', 'u', 'n'], $province);
    $province = str_replace([' de ', ' y '], ' ', $province);
    return trim(preg_replace('/\s+/', ' ', $province));
}

// En ImportRestaurantsData.php línea 200 - SIMILAR
// En ImportMuseumsData.php línea 315 - SIMILAR
// En ImportFestivalsData.php línea 211 - SIMILAR
// En HotelsController.php línea 53 - SIMILAR
```

### ✅ SOLUCIÓN: StringHelper (Ampliado)

```php
<?php
namespace App\Helpers;

class StringHelper
{
    public static function normalize(string $str): string
    {
        // ... código anterior
    }

    /**
     * Normalizar nombres de provincia
     * Maneja casos como "Castilla y León" → "castilla y leon"
     */
    public static function normalizeProvince(string $province): string
    {
        // Convertir a minúsculas
        $province = strtolower($province);
        
        // Eliminar tildes
        $province = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n'],
            $province
        );
        
        // Normalizar espacios múltiples
        $province = trim(preg_replace('/\s+/', ' ', $province));
        
        return $province;
    }

    /**
     * Alias para consistencia
     */
    public static function normalizeLocation(string $location): string
    {
        return self::normalize($location);
    }
}
```

**Uso:**
```php
// En los 5 archivos, reemplazar método privado por:
use App\Helpers\StringHelper;

// ... en handle() o índice
$normalized = StringHelper::normalizeProvince($province);
```

---

## 4️⃣ CREAR MÉTODO Plan::isOwnedBy()

### ❌ PROBLEMA ACTUAL (3 duplicaciones de auth check)
```php
// En PlanesController::show() línea 87
$userColumn = Plan::userColumn();
if ($plan->{$userColumn} !== Auth::id()) {
    abort(403, 'No tienes permiso para acceder a este plan.');
}

// En PlanesController::finalize() línea 136 - IDÉNTICO
$userColumn = Plan::userColumn();
if ($plan->{$userColumn} !== Auth::id()) {
    abort(403, 'No tienes permiso para acceder a este plan.');
}

// En PlanesController::destroy() línea 168 - IDÉNTICO
```

### ✅ SOLUCIÓN: Método en Modelo

**En `app/Models/Plan.php`:**
```php
<?php
namespace App\Models;

use Illuminate\Support\Facades\Auth;

class Plan extends Model
{
    // ... propiedades existentes
    
    /**
     * Obtener la columna de usuario según la versión de base de datos
     * (Handle migración de id_user a user_id)
     */
    public static function userColumn(): string
    {
        $table = (new static())->getTable();
        if (Schema::hasColumn($table, 'id_user')) {
            return 'id_user';
        }
        return 'user_id';
    }
    
    /**
     * Verificar si el plan pertenece al usuario actual
     * NUEVO MÉTODO - Reemplaza el check duplicado
     */
    public function isOwnedBy($userId): bool
    {
        $userColumn = self::userColumn();
        return $this->{$userColumn} === $userId;
    }
    
    /**
     * Scope helper para filtrar planes del usuario
     */
    public function scopeOwnedBy($query, $userId)
    {
        $userColumn = self::userColumn();
        return $query->where($userColumn, $userId);
    }
}
```

**Uso en Controller:**
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PlanesController extends Controller
{
    public function show($id)
    {
        $plan = Plan::findOrFail($id);
        
        // REEMPLAZAR 3 líneas por 1:
        // ❌ ANTES:
        // $userColumn = Plan::userColumn();
        // if ($plan->{$userColumn} !== Auth::id()) {
        //     abort(403, 'No tienes permiso...');
        // }
        
        // ✅ DESPUÉS:
        if (!$plan->isOwnedBy(Auth::id())) {
            abort(403, 'No tienes permiso para acceder a este plan.');
        }
        
        // ... resto del código
    }
    
    public function finalize($id)
    {
        $plan = Plan::findOrFail($id);
        
        if (!$plan->isOwnedBy(Auth::id())) {
            abort(403, 'No tienes permiso para acceder a este plan.');
        }
        
        // ... resto
    }
    
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        
        if (!$plan->isOwnedBy(Auth::id())) {
            abort(403, 'No tienes permiso para acceder a este plan.');
        }
        
        // ... resto
    }
    
    // ALTERNATIVA: Usar scope en queries
    public function myPlans()
    {
        $plans = Plan::ownedBy(Auth::id())
            ->where('status', 'completado')
            ->get();
        
        return view('mis-planes', ['plans' => $plans]);
    }
}
```

---

## 5️⃣ CREAR BasePublicResourceController

### ❌ PROBLEMA ACTUAL (4 controllers 70% idénticos)
```php
// HotelsController.php
class HotelsController extends Controller {
    public function index() {
        $provinces = PublicHotel::getProvinces();
        return view('hoteles', ['provinces' => $provinces]);
    }
    
    public function filterByLocality($locality) {
        $hotels = PublicHotel::byLocality($locality);
        return response()->json($hotels);
    }
}

// RestaurantsController.php - CASI IDÉNTICO
// MuseumsController.php - CASI IDÉNTICO
// FestivalsController.php - CASI IDÉNTICO
```

### ✅ SOLUCIÓN: Controller Base Abstracto

**Crear `app/Http/Controllers/BasePublicResourceController.php`:**
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BasePublicResourceController extends Controller
{
    /**
     * Especificar en subclase
     */
    protected string $modelClass;
    protected string $viewName;
    protected string $resourceName; // 'hotel', 'restaurant', etc.
    
    /**
     * Mostrar página principal con selectores
     */
    public function index()
    {
        $provinces = $this->modelClass::getProvinces();
        
        return view($this->viewName, [
            'provinces' => $provinces,
        ]);
    }
    
    /**
     * Filtrar por localidad
     */
    public function filterByLocality(string $locality)
    {
        $resources = $this->modelClass::byLocality($locality);
        
        return response()->json($resources);
    }
    
    /**
     * Ver detalles de un recurso
     */
    public function show($id)
    {
        $resource = $this->modelClass::findOrFail($id);
        
        return view("{$this->resourceName}-detail", [
            $this->resourceName => $resource,
        ]);
    }
}
```

**Usar en Subclases:**
```php
<?php
namespace App\Http\Controllers;

use App\Models\PublicHotel;

class HotelsController extends BasePublicResourceController
{
    protected string $modelClass = PublicHotel::class;
    protected string $viewName = 'hoteles';
    protected string $resourceName = 'hotel';
}

// RestaurantsController
class RestaurantsController extends BasePublicResourceController
{
    protected string $modelClass = PublicRestaurant::class;
    protected string $viewName = 'restaurantes';
    protected string $resourceName = 'restaurant';
}

// MuseumsController
class MuseumsController extends BasePublicResourceController
{
    protected string $modelClass = PublicMuseum::class;
    protected string $viewName = 'museos';
    protected string $resourceName = 'museum';
}

// FestivalsController
class FestivalsController extends BasePublicResourceController
{
    protected string $modelClass = PublicFestival::class;
    protected string $viewName = 'fiestas';
    protected string $resourceName = 'festival';
}
```

**Resultado:**
- De 4 controllers con ~200 líneas c/u → 4 controllers con ~10 líneas c/u + 1 base con 50 líneas
- Cambios en lógica común se hacen en 1 archivo
- Fácil agregar nuevos recursos

---

## 6️⃣ SIMPLIFICAR FILTRADO DE HOTELES

### ❌ PROBLEMA ACTUAL (20 líneas complejas)
```php
// PlanWizardController::hoteles() línea 82
$hotels = $allHotels->filter(function($hotel) use ($provinciaNormalizada, $municipioNormalizado, $normalizeString) {
    $hotelProvince = $normalizeString($hotel->province);
    $hotelLocality = $normalizeString($hotel->locality);
    
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

### ✅ SOLUCIÓN: Usar SQL + Método Privado

**En `app/Http/Controllers/PlanWizardController.php`:**
```php
<?php
use App\Helpers\StringHelper;

class PlanWizardController extends Controller
{
    public function hoteles(Request $request)
    {
        $draft = Session::get('draft_plan');
        if (!$draft) {
            return redirect()->route('planes')
                ->with('error', 'Por favor selecciona provincia, municipio y fechas');
        }

        // Obtener provincias
        $provinces = PublicHotel::getProvinces();
        
        // Filtrar hoteles - SIMPLIFICADO
        $hotels = $this->filterHotels(
            $draft['provincia'],
            $draft['municipio']
        );

        return view('plan-wizard.hoteles', [
            'draft' => $draft,
            'hotels' => $hotels,
            'provinces' => $provinces,
        ]);
    }

    /**
     * Filtrar hoteles por provincia y municipio
     * MÉTODO PRIVADO - Encapsula lógica de filtrado
     */
    private function filterHotels(string $province, string $municipality)
    {
        $normalizedProvince = StringHelper::normalize($province);
        $normalizedMunicipality = StringHelper::normalize($municipality);
        
        // Usar SQL LIKE en lugar de filtro en PHP
        return PublicHotel::active()
            ->where(function($q) use ($normalizedProvince) {
                $q->whereRaw("LOWER(REPLACE(REPLACE(province, 'á', 'a'), 'é', 'e')) LIKE ?", 
                            ["%{$normalizedProvince}%"])
                  ->orWhere('province', 'LIKE', "%{$province}%");
            })
            ->where(function($q) use ($normalizedMunicipality) {
                $q->whereRaw("LOWER(REPLACE(REPLACE(locality, 'á', 'a'), 'é', 'e')) LIKE ?", 
                            ["%{$normalizedMunicipality}%"])
                  ->orWhere('locality', 'LIKE', "%{$municipality}%");
            })
            ->orderBy('name')
            ->get();
    }
}
```

**Ventajas:**
- 2 líneas en `hoteles()` vs 20 antes
- Query en BD vs filtrado en PHP (mejor performance)
- Fácil de debuggear y extender
- Reutilizable en otros métodos

---

## 7️⃣ CONSOLIDAR RUTAS /planes/{id}

### ❌ PROBLEMA ACTUAL (2 rutas idénticas)
```php
// routes/web.php línea 30
Route::get('/mis-planes/{id}', [PlanesController::class, 'show'])
    ->name('mis-planes.show')
    ->middleware('auth');

// Línea 78 - LEGACY
Route::get('/planes/{id}', [PlanesController::class, 'show'])
    ->name('detalle-plan');

// Línea 110 - ¡¡RUTA DUPLICADA PROBLEMÁTICA!!
Route::get('/planes/{id}', function ($id) {
    return view('detalle-plan');
})->name('detalle-plan');  // ← MISMO NOMBRE, SIN AUTH
```

### ✅ SOLUCIÓN: Unificar Rutas

```php
// routes/web.php - NUEVO

// Ruta principal protegida (para usuarios autenticados)
Route::get('/mis-planes/{id}', [PlanesController::class, 'show'])
    ->name('mis-planes.show')
    ->middleware('auth');

// Ruta legacy (redirecciona a nueva)
Route::redirect('/planes/{id}', '/mis-planes/{id}');

// Eliminar:
// - Línea 78 (redundante)
// - Línea 110 (peligrosa sin auth)
```

O si quieres mantener backward compatibility:
```php
// routes/web.php - ALTERNATIVA CON REDIRECT

Route::get('/mis-planes/{id}', [PlanesController::class, 'show'])
    ->name('mis-planes.show')
    ->middleware('auth');

// Ruta legacy - redirecciona para mantener links antiguos
Route::get('/planes/{id}', function ($id) {
    return redirect(route('mis-planes.show', $id));
})->name('detalle-plan');
```

**Cambio en vistas:**
```blade
<!-- ANTES -->
<a href="{{ route('detalle-plan', $plan->id) }}">Ver Plan</a>

<!-- DESPUÉS -->
<a href="{{ route('mis-planes.show', $plan->id) }}">Ver Plan</a>
```

---

## 8️⃣ REMOVER VARIABLES DEBUG

### ❌ PROBLEMA ACTUAL
```php
// PlanWizardController::hoteles() línea 106-129
return view('plan-wizard.hoteles', [
    'draft' => $draft,
    'hotels' => $hotels,
    'provinces' => $provinces,
    'hotelsInProvince' => $hotelsInProvince,      // ← DEBUG
    'availableLocalities' => $availableLocalities, // ← DEBUG
    'debugHotels' => $debugHotels,                // ← DEBUG
    'provinciaBuscada' => $provinciaBuscada,      // ← DEBUG
    'municipioBuscado' => $municipioBuscado,      // ← DEBUG
]);
```

### ✅ SOLUCIÓN: Remover si no se usan

```php
// PlanWizardController::hoteles() - LIMPIO
return view('plan-wizard.hoteles', [
    'draft' => $draft,
    'hotels' => $hotels,
    'provinces' => $provinces,
]);
```

**Si necesitas debuggear en development:**
```php
if (config('app.debug')) {
    // Variables debug solo en desarrollo
    $data['debugHotels'] = $debugHotels;
}

return view('plan-wizard.hoteles', $data);
```

---

## 9️⃣ CREAR BLADE COMPONENT PARA GRIDS

### ❌ PROBLEMA ACTUAL (4 vistas 70% idénticas)
```blade
<!-- hoteles.blade.php, restaurantes.blade.php, museos.blade.php, fiestas.blade.php -->
@extends('layouts.app')

<section class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>{{ $title }}</h1>
            <p class="subtitle">{{ $subtitle }}</p>
        </div>
        
        <div id="{{ $gridId }}" class="hotels-grid">
            @if($items->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">Selecciona...</p>
                </div>
            @else
                @foreach($items as $item)
                    <div class="hotel-card">
                        {{-- Contenido específico por tipo --}}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
```

### ✅ SOLUCIÓN: Crear Blade Component

**Crear `resources/views/components/resource-grid.blade.php`:**
```blade
<section class="hotels-section">
    <div class="hotels-container">
        <div class="hotels-header">
            <h1>{{ $title }}</h1>
            <p class="subtitle">{{ $subtitle }}</p>
        </div>

        <div id="{{ $gridId }}" class="hotels-grid">
            @if($items->isEmpty())
                <div class="placeholder-container">
                    <p class="placeholder-text">{{ $emptyMessage }}</p>
                </div>
            @else
                @foreach($items as $item)
                    <div class="hotel-card">
                        <!-- Incluir el slot específico del tipo -->
                        {{ $slot }}
                    </div>
                @endforeach
            @endif
        </div>

        <div id="no-results" class="no-results-message" style="display: none;">
            <p>{{ $noResultsMessage }}</p>
        </div>
    </div>
</section>
```

**Crear `resources/views/components/hotel-card.blade.php`:**
```blade
<div class="hotel-header">
    <div class="hotel-title">
        <h3>{{ $hotel->name }}</h3>
        <p class="hotel-location">📍 {{ $hotel->locality }}, {{ $hotel->province }}</p>
    </div>
</div>

<div class="hotel-body">
    @if($hotel->classification)
        <p class="hotel-classification">
            <strong>Clasificación:</strong> {{ $hotel->classification }}
        </p>
    @endif

    @if($hotel->address)
        <p class="hotel-address">
            <strong>Dirección:</strong> {{ $hotel->address }}
        </p>
    @endif

    {{-- ... más campos --}}
</div>
```

**Usar en vistas:**
```blade
@extends('layouts.app')

@section('content')
    <x-resource-grid 
        title="Alojamientos Hoteleros"
        subtitle="Explora los mejores hoteles disponibles en la región"
        :items="$hotels"
        gridId="hotels-grid"
        emptyMessage="Selecciona una localidad para ver los alojamientos disponibles"
        noResultsMessage="No se encontraron alojamientos para la localidad seleccionada."
    >
        @foreach($hotels as $hotel)
            <x-hotel-card :hotel="$hotel" />
        @endforeach
    </x-resource-grid>
@endsection
```

**Resultado:**
- Reducir de 4 × 240 líneas → ~100 líneas de componentes reutilizables
- Cambios visuales en 1 lugar
- Más mantenible y testeable

---

## 🔟 CREAR BaseImportJob

### ❌ PROBLEMA ACTUAL (3 jobs idénticos)
```php
// ImportHotelsJob.php
class ImportHotelsJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public function handle() {
        Artisan::call('hotels:import');
    }
}

// ImportMuseumsJob.php - IDÉNTICO
// ImportMunicipiosJob.php - IDÉNTICO
```

### ✅ SOLUCIÓN: Crear Job Base

**Crear `app/Jobs/BaseImportJob.php`:**
```php
<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

abstract class BaseImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Especificar el comando a ejecutar
     */
    protected string $command;

    public function handle()
    {
        Artisan::call($this->command);
    }
}
```

**Usar en Jobs específicos:**
```php
<?php
namespace App\Jobs;

class ImportHotelsJob extends BaseImportJob
{
    protected string $command = 'hotels:import';
}

// Equivalente para:
// - ImportMuseumsJob (command = 'museums:import')
// - ImportRestaurantsJob (command = 'restaurants:import')
// - ImportFestivalsJob (command = 'festivals:import')
// - ImportMunicipiosJob (command = 'municipios:import')
```

**Resultado:**
- De 5 archivos con 18 líneas c/u → 1 base + 5 archivos con 2 líneas c/u
- Comportamiento consistente
- Fácil agregar nuevos imports

---

## 📋 CHECKLIST DE IMPLEMENTACIÓN

- [ ] Crear `app/Helpers/StringHelper.php` con `normalize()` y `normalizeProvince()`
- [ ] Crear `app/Models/Traits/PublicResourceTrait.php`
- [ ] Actualizar 4 modelos (PublicHotel, Restaurant, Museum, Festival) para usar Trait
- [ ] Crear `app/Models/Traits/Plan.php` método `isOwnedBy()`
- [ ] Refactorizar PlanesController para usar `isOwnedBy()`
- [ ] Crear `app/Http/Controllers/BasePublicResourceController.php`
- [ ] Simplificar 4 controllers de recursos para extender base
- [ ] Crear método `filterHotels()` privado en PlanWizardController
- [ ] Consolidar rutas en `routes/web.php`
- [ ] Remover variables debug de vistas
- [ ] Crear componentes Blade (`resource-grid.blade.php`, `hotel-card.blade.php`, etc.)
- [ ] Crear `app/Jobs/BaseImportJob.php`
- [ ] Simplificar 5 Job classes

---

*Ejemplos completos listos para implementación. Cada sección es independiente y puede hacerse de forma gradual.*
