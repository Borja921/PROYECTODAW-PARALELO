<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanesController extends Controller
{
    public function index(Request $request)
    {
        // Obtener mapping provincia => [municipios]
        $rows = Municipio::select('provincia', 'municipio')
            ->orderBy('provincia')
            ->orderBy('municipio')
            ->get()
            ->groupBy('provincia')
            ->map(function ($items) {
                return $items->pluck('municipio')->unique()->values();
            })->toArray();

        // Provincias ordenadas
        $provinces = array_keys($rows);

        return view('planes', [
            'provinces' => $provinces,
            'municipios_map' => $rows
        ]);
    }

    public function store(\App\Http\Requests\PlanStoreRequest $request)
    {
        $data = $request->validated();

        $start = \Carbon\Carbon::createFromFormat('Y-m-d', $data['start_date']);
        $end = \Carbon\Carbon::createFromFormat('Y-m-d', $data['end_date']);
        $days = $start->diffInDays($end) + 1;

        $userColumn = \App\Models\Plan::userColumn();
        $planData = [
            'provincia' => $data['provincia'],
            'municipio' => $data['municipio'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'days' => $days,
            'items' => isset($data['items']) ? json_decode($data['items'], true) : null,
        ];
        $userId = Auth::id();
        $planData[$userColumn] = $userId;

        if ($userColumn === 'id_user' && \Illuminate\Support\Facades\Schema::hasColumn((new \App\Models\Plan())->getTable(), 'user_id')) {
            $planData['user_id'] = null;
        }

        $plan = \App\Models\Plan::create($planData);

        return redirect()->route('planes')->with('success', 'Plan guardado correctamente.');
    }

    /**
     * Mostrar los planes del usuario autenticado
     */
    public function myPlans()
    {
        $userId = Auth::id();
        $userColumn = \App\Models\Plan::userColumn();
        $plans = \App\Models\Plan::where($userColumn, $userId)->orderBy('created_at', 'desc')->get();

        // Contar planes por estado
        $totalPlans = $plans->count();
        $finalizados = $plans->where('status', 'completado')->count();
        $sinFinalizar = $plans->where('status', '!=', 'completado')->count();
        $favoritos = $plans->where('is_favorite', true)->count();

        return view('mis-planes', [
            'plans' => $plans,
            'totalPlans' => $totalPlans,
            'finalizados' => $finalizados,
            'sinFinalizar' => $sinFinalizar,
            'favoritos' => $favoritos
        ]);
    }

    /**
     * Mostrar detalle de un plan (solo si pertenece al usuario o si es público)
     */
    public function show($id)
    {
        $plan = \App\Models\Plan::findOrFail($id);
        $userColumn = \App\Models\Plan::userColumn();

        // Autorizar: solo el propietario puede ver su plan
        if ($plan->{$userColumn} !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este plan.');
        }

        $items = $plan->items ?? [];

        $hotelIds = collect($items['hotels'] ?? [])->pluck('id')->filter()->values();
        $restaurantIds = collect($items['restaurantes'] ?? [])->pluck('id')->filter()->values();
        $museumIds = collect($items['museos'] ?? [])->pluck('id')->filter()->values();
        $festivalIds = collect($items['fiestas'] ?? [])->pluck('id')->filter()->values();

        $selectedHotels = $hotelIds->isNotEmpty()
            ? \App\Models\PublicHotel::whereIn('id', $hotelIds)->get()
            : collect();

        $selectedRestaurants = $restaurantIds->isNotEmpty()
            ? \App\Models\PublicRestaurant::whereIn('id', $restaurantIds)->get()
            : collect();

        $selectedMuseums = $museumIds->isNotEmpty()
            ? \App\Models\PublicMuseum::whereIn('id', $museumIds)->get()
            : collect();

        $selectedFestivals = $festivalIds->isNotEmpty()
            ? \App\Models\PublicFestival::whereIn('id', $festivalIds)->get()
            : collect();

        return view('detalle-plan', [
            'plan' => $plan,
            'selectedHotels' => $selectedHotels,
            'selectedRestaurants' => $selectedRestaurants,
            'selectedMuseums' => $selectedMuseums,
            'selectedFestivals' => $selectedFestivals,
        ]);
    }

    /**
     * Finalizar un plan (cambiar estado a completado)
     */
    public function finalize($id)
    {
        $plan = \App\Models\Plan::findOrFail($id);
        $userColumn = \App\Models\Plan::userColumn();

        // Autorizar: solo el propietario puede finalizar su plan
        if ($plan->{$userColumn} !== Auth::id()) {
            abort(403, 'No tienes permiso para finalizar este plan.');
        }

        $plan->status = 'completado';
        $plan->save();

        return redirect()->route('mis-planes.show', $plan->id)
            ->with('success', 'Plan finalizado correctamente.');
    }

    /**
     * Eliminar un plan
     */
    public function destroy($id)
    {
        $plan = \App\Models\Plan::findOrFail($id);
        $userColumn = \App\Models\Plan::userColumn();

        // Autorizar: solo el propietario puede eliminar su plan
        if ($plan->{$userColumn} !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este plan.');
        }

        $plan->delete();

        return redirect()->route('mis-planes')
            ->with('success', 'Plan eliminado correctamente.');
    }

    public function toggleFavorite($id)
    {
        $plan = \App\Models\Plan::findOrFail($id);
        $userColumn = \App\Models\Plan::userColumn();

        // Autorizar: solo el propietario puede marcar como favorito
        if ($plan->{$userColumn} !== Auth::id()) {
            abort(403, 'No tienes permiso para hacer esto.');
        }

        // Cambiar estado de favorito
        $plan->is_favorite = !$plan->is_favorite;
        $plan->save();

        return response()->json([
            'success' => true,
            'is_favorite' => $plan->is_favorite,
            'message' => $plan->is_favorite ? 'Plan agregado a favoritos' : 'Plan removido de favoritos'
        ]);
    }
}
