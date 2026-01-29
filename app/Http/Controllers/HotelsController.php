<?php

namespace App\Http\Controllers;

use App\Models\PublicHotel;

class HotelsController extends Controller
{
    /**
     * Mostrar la lista de hoteles con opciones de filtrado
     */
    public function index()
    {
        // Obtener todas las provincias
        $provinces = PublicHotel::getProvinces();
        
        // Obtener todas las localidades agrupadas por nombre
        $localities = PublicHotel::getLocalitiesWithCount();
        
        // Obtener todos los hoteles activos
        $hotels = PublicHotel::where('is_active', true)
            ->orderBy('province')
            ->orderBy('locality')
            ->orderBy('name')
            ->get();

        return view('hoteles', [
            'provinces' => $provinces,
            'localities' => $localities,
            'hotels' => $hotels
        ]);
    }

    /**
     * Filtrar hoteles por localidad (para AJAX si es necesario)
     */
    public function filterByLocality($locality)
    {
        $hotels = PublicHotel::where('locality', $locality)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return response()->json($hotels);
    }

    /**
     * Mostrar detalles de un hotel específico
     */
    public function show($id)
    {
        $hotel = PublicHotel::findOrFail($id);
        
        return view('hotel-detail', [
            'hotel' => $hotel
        ]);
    }
}
