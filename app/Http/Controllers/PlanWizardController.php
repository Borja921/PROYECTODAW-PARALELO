<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\PublicHotel;

class PlanWizardController extends Controller
{
    public function __construct()
    {
        // Requiere que el usuario esté autenticado para usar el wizard
        $this->middleware('auth');
    }

    /**
     * Limpiar la sesión anterior (para iniciar un nuevo plan)
     */
    public function resetDraft()
    {
        Session::forget('draft_plan');
        return redirect()->route('planes')->with('success', 'Nuevo plan iniciado. Por favor completa los detalles.');
    }

    /**
     * Guardar paso 1 (provincia, municipio, fechas) en sesión y redirigir a hoteles
     */
    public function saveStep1(Request $request)
    {
        $data = $request->validate([
            'provincia' => 'required|string',
            'municipio' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        // Guardar en sesión como borrador de plan
        Session::put('draft_plan', $data);

        return redirect()->route('plan.wizard.hoteles');
    }

    /**
     * Mostrar hoteles filtrados por provincia/localidad guardadas en el draft
     */
    public function hoteles()
    {
        $draft = Session::get('draft_plan');
        if (!$draft) {
            return redirect()->route('planes')->with('error', 'Por favor selecciona provincia, municipio y fechas antes de continuar.');
        }

        // Función para normalizar strings (quitar tildes, caracteres especiales y corruptos)
        $normalizeString = function($str) {
            // Primero intentar arreglar encoding corrupto
            if (mb_detect_encoding($str, 'UTF-8', true) === false) {
                $str = utf8_encode($str);
            }
            
            $str = strtolower($str);
            // Reemplazar caracteres con tildes
            $str = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', 'à', 'è', 'ì', 'ò', 'ù'], 
                              ['a', 'e', 'i', 'o', 'u', 'n', 'u', 'a', 'e', 'i', 'o', 'u'], $str);
            // Quitar caracteres no alfanuméricos excepto espacios y guiones
            $str = preg_replace('/[^a-z0-9\s\-]/', '', $str);
            return trim($str);
        };

        // Normalizar los valores del draft
        $provinciaNormalizada = $normalizeString($draft['provincia']);
        $municipioNormalizado = $normalizeString($draft['municipio']);

        // Obtener todos los hoteles activos y filtrar en PHP
        $allHotels = PublicHotel::where('is_active', true)->get();
        
        // Debug: ver algunos hoteles crudos
        $debugHotels = $allHotels->take(5)->map(function($h) use ($normalizeString) {
            return [
                'original_province' => $h->province,
                'normalized_province' => $normalizeString($h->province),
                'original_locality' => $h->locality,
                'normalized_locality' => $normalizeString($h->locality),
            ];
        });
        
        $hotels = $allHotels->filter(function($hotel) use ($provinciaNormalizada, $municipioNormalizado, $normalizeString) {
            $hotelProvince = $normalizeString($hotel->province);
            $hotelLocality = $normalizeString($hotel->locality);
            
            // Matching exacto o parcial
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

        // Debug: contar todos los hoteles de la provincia
        $hotelsInProvince = $allHotels->filter(function($hotel) use ($provinciaNormalizada, $normalizeString) {
            return $normalizeString($hotel->province) === $provinciaNormalizada;
        })->count();
        
        // Debug: obtener algunos municipios disponibles en esta provincia
        $availableLocalities = $allHotels->filter(function($hotel) use ($provinciaNormalizada, $normalizeString) {
            return $normalizeString($hotel->province) === $provinciaNormalizada;
        })->pluck('locality')->unique()->take(10)->values();

        // Lista de provincias disponibles para el selector
        $provinces = PublicHotel::where('is_active', true)
            ->pluck('province')
            ->unique()
            ->sort()
            ->values();

        return view('plan-wizard.hoteles', [
            'draft' => $draft,
            'hotels' => $hotels,
            'provinces' => $provinces,
            'hotelsInProvince' => $hotelsInProvince,
            'availableLocalities' => $availableLocalities,
            'debugHotels' => $debugHotels,
            'provinciaBuscada' => $provinciaNormalizada,
            'municipioBuscado' => $municipioNormalizado,
        ]);
    }

    /**
     * Guardar selección de hotel (opcional) y continuar al siguiente paso
     */
    public function saveHotel(Request $request)
    {
        $data = $request->validate([
            'hotel_ids' => 'nullable|array',
            'hotel_ids.*' => 'exists:public_hotels,id',
        ]);

        $draft = Session::get('draft_plan', []);
        if (!empty($data['hotel_ids'])) {
            $hotels = PublicHotel::whereIn('id', $data['hotel_ids'])->get();
            $draft['hotels'] = $hotels->map(function($hotel) {
                return ['id' => $hotel->id, 'name' => $hotel->name];
            })->toArray();
        } else {
            unset($draft['hotels']);
        }

        Session::put('draft_plan', $draft);

        // Redirigir al siguiente paso (restaurantes). Vista implementada en pasos posteriores.
        return redirect()->route('plan.wizard.restaurantes');
    }

    /**
     * Stub para restaurantes (siguiente paso) — se implementará en siguientes iteraciones
     */
    public function restaurantes()
    {
        $draft = Session::get('draft_plan');
        if (!$draft) {
            return redirect()->route('planes')->with('error', 'Por favor selecciona provincia, municipio y fechas antes de continuar.');
        }

        // Función para normalizar strings (igual que en hoteles)
        $normalizeString = function($str) {
            // Primero intentar arreglar encoding corrupto
            if (mb_detect_encoding($str, 'UTF-8', true) === false) {
                $str = utf8_encode($str);
            }
            
            $str = strtolower($str);
            // Reemplazar caracteres con tildes
            $str = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', 'à', 'è', 'ì', 'ò', 'ù'], 
                              ['a', 'e', 'i', 'o', 'u', 'n', 'u', 'a', 'e', 'i', 'o', 'u'], $str);
            // Quitar caracteres no alfanuméricos excepto espacios y guiones
            $str = preg_replace('/[^a-z0-9\s\-]/', '', $str);
            return trim($str);
        };

        // Normalizar los valores del draft
        $provinciaNormalizada = $normalizeString($draft['provincia']);
        $municipioNormalizado = $normalizeString($draft['municipio']);

        // Obtener todos los restaurantes activos y filtrar en PHP
        $allRestaurants = \App\Models\PublicRestaurant::where('is_active', true)->get();
        
        $restaurants = $allRestaurants->filter(function($restaurant) use ($provinciaNormalizada, $municipioNormalizado, $normalizeString) {
            $restaurantProvince = $normalizeString($restaurant->province);
            $restaurantLocality = $normalizeString($restaurant->locality);
            
            // Matching exacto o parcial
            $provinciaMatch = ($restaurantProvince === $provinciaNormalizada) || 
                              (strlen($restaurantProvince) > 2 && strlen($provinciaNormalizada) > 2 && 
                               (strpos($provinciaNormalizada, $restaurantProvince) !== false || 
                                strpos($restaurantProvince, $provinciaNormalizada) !== false));
            
            $localidadMatch = ($restaurantLocality === $municipioNormalizado) ||
                              (strlen($restaurantLocality) > 2 && strlen($municipioNormalizado) > 2 &&
                               (strpos($municipioNormalizado, $restaurantLocality) !== false || 
                                strpos($restaurantLocality, $municipioNormalizado) !== false));
            
            return $provinciaMatch && $localidadMatch;
        })->sortBy('name')->values();

        return view('plan-wizard.restaurantes', ['draft' => $draft, 'restaurants' => $restaurants]);
    }

    public function saveRestaurante(Request $request)
    {
        $data = $request->validate([
            'restaurante_ids' => 'nullable|array',
            'restaurante_ids.*' => 'exists:public_restaurants,id',
        ]);

        $draft = Session::get('draft_plan', []);
        if (!empty($data['restaurante_ids'])) {
            $restaurants = \App\Models\PublicRestaurant::whereIn('id', $data['restaurante_ids'])->get();
            $draft['restaurantes'] = $restaurants->map(function($restaurant) {
                return ['id' => $restaurant->id, 'name' => $restaurant->name];
            })->toArray();
        } else {
            unset($draft['restaurantes']);
        }
        Session::put('draft_plan', $draft);

        return redirect()->route('plan.wizard.museos');
    }

    public function museos()
    {
        $draft = Session::get('draft_plan');
        if (!$draft) {
            return redirect()->route('planes')->with('error', 'Por favor selecciona provincia, municipio y fechas antes de continuar.');
        }

        // Función para normalizar strings (igual que en hoteles/restaurantes)
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

        $provinciaNormalizada = $normalizeString($draft['provincia']);
        $municipioNormalizado = $normalizeString($draft['municipio']);

        $allMuseums = \App\Models\PublicMuseum::where('is_active', true)->get();

        $museums = $allMuseums->filter(function($museum) use ($municipioNormalizado, $normalizeString) {
            $museumProvince = $normalizeString($museum->province);
            $museumLocality = $normalizeString($museum->locality);

            $localidadMatch = ($museumLocality === $municipioNormalizado) ||
                              (strlen($museumLocality) > 2 && strlen($municipioNormalizado) > 2 &&
                               (strpos($municipioNormalizado, $museumLocality) !== false ||
                                strpos($museumLocality, $municipioNormalizado) !== false));

            return $localidadMatch;
        })->sortBy('name')->values();

        return view('plan-wizard.museos', ['draft' => $draft, 'museums' => $museums]);
    }

    public function saveMuseo(Request $request)
    {
        $data = $request->validate([
            'museo_ids' => 'nullable|array',
            'museo_ids.*' => 'exists:public_museums,id',
        ]);

        $draft = Session::get('draft_plan', []);
        if (!empty($data['museo_ids'])) {
            $museums = \App\Models\PublicMuseum::whereIn('id', $data['museo_ids'])->get();
            $draft['museos'] = $museums->map(function($m) {
                return ['id' => $m->id, 'name' => $m->name];
            })->toArray();
        } else {
            unset($draft['museos']);
        }
        Session::put('draft_plan', $draft);

        return redirect()->route('plan.wizard.fiestas');
    }

    public function fiestas()
    {
        $draft = Session::get('draft_plan');
        if (!$draft) {
            return redirect()->route('planes')->with('error', 'Por favor selecciona provincia, municipio y fechas antes de continuar.');
        }

        $festivals = \App\Models\PublicFestival::where('province', $draft['provincia'])
            ->where('locality', $draft['municipio'])
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('plan-wizard.fiestas', ['draft' => $draft, 'festivals' => $festivals]);
    }

    public function saveFiesta(Request $request)
    {
        $data = $request->validate([
            'fiesta_ids' => 'nullable|array',
            'fiesta_ids.*' => 'exists:public_festivals,id',
        ]);

        $draft = Session::get('draft_plan', []);
        if (!empty($data['fiesta_ids'])) {
            $festivals = \App\Models\PublicFestival::whereIn('id', $data['fiesta_ids'])->get();
            $draft['fiestas'] = $festivals->map(function($f) {
                return ['id' => $f->id, 'name' => $f->name, 'date' => $f->start_date];
            })->toArray();
        } else {
            unset($draft['fiestas']);
        }
        Session::put('draft_plan', $draft);

        return redirect()->route('plan.wizard.summary');
    }

    public function summary()
    {
        $draft = Session::get('draft_plan');
        if (!$draft) {
            return redirect()->route('planes')->with('error', 'No hay un plan en progreso.');
        }

        return view('plan-wizard.summary', ['draft' => $draft]);
    }

    public function finalize(Request $request)
    {
        $data = $request->validate([
            'plan_name' => 'nullable|string|max:255',
        ]);

        $draft = Session::get('draft_plan');
        if (!$draft) {
            return redirect()->route('planes')->with('error', 'No hay un plan en progreso.');
        }

        // Guardar nombre en draft
        if (!empty($data['plan_name'])) {
            $draft['plan_name'] = $data['plan_name'];
        }
        Session::put('draft_plan', $draft);

        $draftHash = md5(json_encode($draft));
        if (Session::get('plan_saved_hash') === $draftHash) {
            return redirect()->route('plan.wizard.summary')->with('success', 'Plan guardado correctamente.');
        }

        // Calcular días
        $start = \Carbon\Carbon::createFromFormat('Y-m-d', $draft['start_date']);
        $end = \Carbon\Carbon::createFromFormat('Y-m-d', $draft['end_date']);
        $days = $start->diffInDays($end) + 1;

        $userColumn = \App\Models\Plan::userColumn();
        $planData = [
            'name' => $draft['plan_name'] ?? 'Plan sin nombre',
            'provincia' => $draft['provincia'],
            'municipio' => $draft['municipio'],
            'start_date' => $draft['start_date'],
            'end_date' => $draft['end_date'],
            'days' => $days,
            'items' => [
                'hotels' => $draft['hotels'] ?? [],
                'restaurantes' => $draft['restaurantes'] ?? [],
                'museos' => $draft['museos'] ?? [],
                'fiestas' => $draft['fiestas'] ?? [],
            ],
        ];
        $userId = Auth::id();
        $planData[$userColumn] = $userId;

        if ($userColumn === 'id_user' && \Illuminate\Support\Facades\Schema::hasColumn((new \App\Models\Plan())->getTable(), 'user_id')) {
            $planData['user_id'] = null;
        }

        $plan = \App\Models\Plan::create($planData);

        // Marcar como guardado y mantener el draft para mostrar el resumen
        Session::put('plan_saved_hash', $draftHash);

        return redirect()->route('plan.wizard.summary')->with('success', 'Plan guardado correctamente.');
    }

    /**
     * Limpiar la sesión del plan después de completar el flujo
     */
    public function clearDraft()
    {
        Session::forget('draft_plan');
        Session::forget('plan_saved_hash');
        return redirect()->route('mis-planes')->with('success', 'Plan creado exitosamente. Puedes ver tus planes guardados en tu perfil.');
    }

    public function removeItem(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|in:hotels,restaurantes,museos,fiestas',
            'index' => 'required|integer|min:0',
        ]);

        $draft = Session::get('draft_plan', []);
        $category = $data['category'];
        $index = $data['index'];

        if (isset($draft[$category]) && is_array($draft[$category]) && isset($draft[$category][$index])) {
            unset($draft[$category][$index]);
            // Reindexar el array para mantener índices continuos
            $draft[$category] = array_values($draft[$category]);
        }

        Session::put('draft_plan', $draft);

        return redirect()->route('plan.wizard.summary');
    }

    // métodos para museos, fiestas, summary se añadirán en siguientes pasos
}
