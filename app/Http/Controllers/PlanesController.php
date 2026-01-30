<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

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

        $plan = \App\Models\Plan::create([
            'user_id' => auth()->id(),
            'provincia' => $data['provincia'],
            'municipio' => $data['municipio'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'days' => $days,
            'items' => isset($data['items']) ? json_decode($data['items'], true) : null,
        ]);

        return redirect()->route('planes')->with('success', 'Plan guardado correctamente.');
    }
}
