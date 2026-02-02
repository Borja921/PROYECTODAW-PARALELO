<?php

namespace App\Http\Controllers;

use App\Models\PublicRestaurant;

class RestaurantsController extends Controller
{
    /**
     * Mostrar la lista de restaurantes con opciones de filtrado
     */
    public function index()
    {
        // Obtener todas las provincias
        $provinces = PublicRestaurant::getProvinces();
        
        // Obtener todas las localidades agrupadas por nombre
        $localities = PublicRestaurant::getLocalitiesWithCount();
        
        // Obtener parámetro de provincia si existe
        $selectedProvince = request()->get('provincia');
        
        // Obtener todos los restaurantes activos
        $query = PublicRestaurant::where('is_active', true);
        
        // Filtrar por provincia si se proporciona
        if ($selectedProvince) {
            $query->where('province', $selectedProvince);
        }
        
        $restaurants = $query->orderBy('province')
            ->orderBy('locality')
            ->orderBy('name')
            ->get();

        return view('restaurantes', [
            'provinces' => $provinces,
            'localities' => $localities,
            'restaurants' => $restaurants,
            'selectedProvince' => $selectedProvince
        ]);
    }

    /**
     * Filtrar restaurantes por localidad (para AJAX si es necesario)
     */
    public function filterByLocality($locality)
    {
        $restaurants = PublicRestaurant::where('locality', $locality)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return response()->json($restaurants);
    }
}
