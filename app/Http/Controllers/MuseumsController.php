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
        
        // Obtener parámetro de provincia si existe
        $selectedProvince = request()->get('provincia');
        
        // Obtener todos los museos activos
        $query = PublicMuseum::where('is_active', true);
        
        // Filtrar por provincia si se proporciona
        if ($selectedProvince) {
            $query->where('province', $selectedProvince);
        }
        
        $museums = $query->orderBy('province')
            ->orderBy('locality')
            ->orderBy('name')
            ->get();

        return view('museos', [
            'provinces' => $provinces,
            'localities' => $localities,
            'museums' => $museums,
            'selectedProvince' => $selectedProvince
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
