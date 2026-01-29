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
        
        // Obtener todos los restaurantes activos
        $restaurants = PublicRestaurant::where('is_active', true)
            ->orderBy('province')
            ->orderBy('locality')
            ->orderBy('name')
            ->get();

        return view('restaurantes', [
            'provinces' => $provinces,
            'localities' => $localities,
            'restaurants' => $restaurants
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
