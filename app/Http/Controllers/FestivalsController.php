<?php

namespace App\Http\Controllers;

use App\Models\PublicFestival;

class FestivalsController extends Controller
{
    /**
     * Mostrar la lista de festivales con opciones de filtrado
     */
    public function index()
    {
        // Obtener todas las provincias
        $provinces = PublicFestival::getProvinces();
        
        // Obtener todas las localidades agrupadas por nombre
        $localities = PublicFestival::getLocalitiesWithCount();
        
        // Obtener parámetro de provincia si existe
        $selectedProvince = request()->get('provincia');
        
        // Obtener todos los festivales activos
        $query = PublicFestival::where('is_active', true);
        
        // Filtrar por provincia si se proporciona
        if ($selectedProvince) {
            $query->where('province', $selectedProvince);
        }
        
        $festivals = $query->orderBy('start_date', 'desc')
            ->orderBy('province')
            ->orderBy('locality')
            ->orderBy('name')
            ->get();

        return view('fiestas', [
            'provinces' => $provinces,
            'localities' => $localities,
            'festivals' => $festivals,
            'selectedProvince' => $selectedProvince
        ]);
    }

    /**
     * Filtrar festivales por localidad (para AJAX si es necesario)
     */
    public function filterByLocality($locality)
    {
        $festivals = PublicFestival::where('locality', $locality)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->orderBy('name')
            ->get();

        return response()->json($festivals);
    }
}
