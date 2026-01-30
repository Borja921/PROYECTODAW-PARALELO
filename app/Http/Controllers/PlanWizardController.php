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

        return view('plan-wizard.hoteles', [
            'draft' => $draft,
            'hotels' => $hotels,
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

        // Por ahora mostramos una vista sencilla que permitirá continuar el wizard en próximas tareas
        return view('plan-wizard.restaurantes', ['draft' => $draft]);
    }

    public function saveRestaurante(Request $request)
    {
        // Implementación posterior
        $data = $request->validate([
            'restaurante_id' => 'nullable|exists:public_restaurants,id',
        ]);

        $draft = Session::get('draft_plan', []);
        if (!empty($data['restaurante_id'])) {
            $draft['restaurante'] = ['id' => $data['restaurante_id']];
        } else {
            unset($draft['restaurante']);
        }
        Session::put('draft_plan', $draft);

        return redirect()->route('plan.wizard.museos');
    }

    // métodos para museos, fiestas, summary se añadirán en siguientes pasos
}
