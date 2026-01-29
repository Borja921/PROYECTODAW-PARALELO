<?php

namespace App\Http\Controllers;

use App\Models\PublicMuseum;

class MuseumsController extends Controller
{
    /**
     * Mostrar la lista de museos con opciones de filtrado
     */
    public function index()
    {
        // Obtener todas las provincias
        $provinces = PublicMuseum::getProvinces();
        
        // Obtener todas las localidades agrupadas por nombre
        $localities = PublicMuseum::getLocalitiesWithCount();
        
        // Obtener todos los museos activos
        $museums = PublicMuseum::where('is_active', true)
            ->orderBy('province')
            ->orderBy('locality')
            ->orderBy('name')
            ->get();

        return view('museos', [
            'provinces' => $provinces,
            'localities' => $localities,
            'museums' => $museums
        ]);
    }

    /**
     * Filtrar museos por localidad (para AJAX si es necesario)
     */
    public function filterByLocality($locality)
    {
        $museums = PublicMuseum::where('locality', $locality)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return response()->json($museums);
    }
}
