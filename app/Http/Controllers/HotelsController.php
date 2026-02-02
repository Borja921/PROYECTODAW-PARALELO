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
        
        // Obtener parámetro de provincia si existe
        $selectedProvince = request()->get('provincia');
        $normalizedSelected = $this->normalizeProvince($selectedProvince);
        if ($selectedProvince && $normalizedSelected) {
            $matchedProvince = $provinces->first(function ($prov) use ($normalizedSelected) {
                return $this->normalizeProvince($prov) === $normalizedSelected;
            });
            if ($matchedProvince) {
                $selectedProvince = $matchedProvince;
            }
        }
        
        // Obtener todos los hoteles activos
        $query = PublicHotel::where('is_active', true);
        
        // Filtrar por provincia si se proporciona
        if ($selectedProvince) {
            $query->where('province', $selectedProvince);
        }
        
        $hotels = $query->orderBy('province')
            ->orderBy('locality')
            ->orderBy('name')
            ->get();

        return view('hoteles', [
            'provinces' => $provinces,
            'localities' => $localities,
            'hotels' => $hotels,
            'selectedProvince' => $selectedProvince
        ]);
    }

    private function normalizeProvince(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $value = trim($value);
        if ($value === '') {
            return null;
        }
        $normalized = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        if ($normalized === false) {
            $normalized = $value;
        }
        return strtolower($normalized);
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
