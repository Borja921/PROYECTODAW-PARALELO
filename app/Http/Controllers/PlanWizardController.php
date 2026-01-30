<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\PublicHotel;

class PlanWizardController extends Controller
{
    public function __construct()
    {
        // Requiere que el usuario esté autenticado para usar el wizard
        $this->middleware('auth');
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

        // Buscar hoteles por provincia/locality (campo 'locality' en PublicHotel)
        $hotels = PublicHotel::where('province', $draft['provincia'])
            ->where('locality', $draft['municipio'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Lista de provincias disponibles para el selector (puede limitarse a todas las provincias activas)
        $provinces = PublicHotel::where('is_active', true)
            ->pluck('province')
            ->unique()
            ->sort()
            ->values();

        return view('plan-wizard.hoteles', [
            'draft' => $draft,
            'hotels' => $hotels,
            'provinces' => $provinces,
        ]);
    }

    /**
     * Guardar selección de hotel (opcional) y continuar al siguiente paso
     */
    public function saveHotel(Request $request)
    {
        $data = $request->validate([
            'hotel_id' => 'nullable|exists:public_hotels,id',
        ]);

        $draft = Session::get('draft_plan', []);
        if (!empty($data['hotel_id'])) {
            $hotel = PublicHotel::find($data['hotel_id']);
            if ($hotel) {
                $draft['hotel'] = ['id' => $hotel->id, 'name' => $hotel->name];
            }
        } else {
            unset($draft['hotel']);
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

        // Buscar restaurantes por provincia/locality
        $restaurants = \App\Models\PublicRestaurant::where('province', $draft['provincia'])
            ->where('locality', $draft['municipio'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('plan-wizard.restaurantes', ['draft' => $draft, 'restaurants' => $restaurants]);
    }

    public function saveRestaurante(Request $request)
    {
        $data = $request->validate([
            'restaurante_id' => 'nullable|exists:public_restaurants,id',
        ]);

        $draft = Session::get('draft_plan', []);
        if (!empty($data['restaurante_id'])) {
            $restaurant = \App\Models\PublicRestaurant::find($data['restaurante_id']);
            if ($restaurant) {
                $draft['restaurante'] = ['id' => $restaurant->id, 'name' => $restaurant->name];
            }
        } else {
            unset($draft['restaurante']);
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

        $museums = \App\Models\PublicMuseum::where('province', $draft['provincia'])
            ->where('locality', $draft['municipio'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('plan-wizard.museos', ['draft' => $draft, 'museums' => $museums]);
    }

    public function saveMuseo(Request $request)
    {
        $data = $request->validate([
            'museo_id' => 'nullable|exists:public_museums,id',
        ]);

        $draft = Session::get('draft_plan', []);
        if (!empty($data['museo_id'])) {
            $m = \App\Models\PublicMuseum::find($data['museo_id']);
            if ($m) {
                $draft['museo'] = ['id' => $m->id, 'name' => $m->name];
            }
        } else {
            unset($draft['museo']);
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
            'fiesta_id' => 'nullable|exists:public_festivals,id',
        ]);

        $draft = Session::get('draft_plan', []);
        if (!empty($data['fiesta_id'])) {
            $f = \App\Models\PublicFestival::find($data['fiesta_id']);
            if ($f) {
                $draft['fiesta'] = ['id' => $f->id, 'name' => $f->name, 'date' => $f->start_date];
            }
        } else {
            unset($draft['fiesta']);
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
        $draft = Session::get('draft_plan');
        if (!$draft) {
            return redirect()->route('planes')->with('error', 'No hay un plan en progreso.');
        }

        // Calcular días
        $start = \Carbon\Carbon::createFromFormat('Y-m-d', $draft['start_date']);
        $end = \Carbon\Carbon::createFromFormat('Y-m-d', $draft['end_date']);
        $days = $start->diffInDays($end) + 1;

        $plan = \App\Models\Plan::create([
            'user_id' => auth()->id(),
            'provincia' => $draft['provincia'],
            'municipio' => $draft['municipio'],
            'start_date' => $draft['start_date'],
            'end_date' => $draft['end_date'],
            'days' => $days,
            'items' => [
                'hotel' => $draft['hotel'] ?? null,
                'restaurante' => $draft['restaurante'] ?? null,
                'museo' => $draft['museo'] ?? null,
                'fiesta' => $draft['fiesta'] ?? null,
            ],
        ]);

        // Limpiar draft
        Session::forget('draft_plan');

        return redirect()->route('mis-planes')->with('success', 'Plan finalizado y guardado correctamente.');
    }

    // métodos para museos, fiestas, summary se añadirán en siguientes pasos
}
