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

        // Función para normalizar strings
        $normalizeString = function($str) {
            if (mb_detect_encoding($str, 'UTF-8', true) === false) {
                $str = utf8_encode($str);
            }

            $str = strtolower($str);
            // Primero reemplazar ? por espacio vacío para manejar casos como "le?n"
            $str = str_replace('?', '', $str);
            $str = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', 'à', 'è', 'ì', 'ò', 'ù'],
                              ['a', 'e', 'i', 'o', 'u', 'n', 'u', 'a', 'e', 'i', 'o', 'u'], $str);
            $str = preg_replace('/[^a-z0-9\s\-]/', '', $str);
            return trim($str);
        };

        // Obtener todos los museos activos
        $allMuseums = PublicMuseum::where('is_active', true)->get();

        // Filtrar por locality basado en la provincia seleccionada
        if ($selectedProvince) {
            $provinciaNormalizada = $normalizeString($selectedProvince);
            
            $museums = $allMuseums->filter(function($museum) use ($provinciaNormalizada, $normalizeString) {
                $museumLocality = $normalizeString($museum->locality);
                
                // Comparación exacta o por similitud (para manejar casos como le?n vs leon)
                if ($museumLocality === $provinciaNormalizada) {
                    return true;
                }
                
                // Si las primeras 2-3 letras coinciden y la longitud es similar, considerar match
                $len1 = strlen($museumLocality);
                $len2 = strlen($provinciaNormalizada);
                
                if (abs($len1 - $len2) <= 1 && $len1 >= 3) {
                    $prefix1 = substr($museumLocality, 0, 2);
                    $prefix2 = substr($provinciaNormalizada, 0, 2);
                    if ($prefix1 === $prefix2) {
                        return true;
                    }
                }
                
                return false;
            })->sortBy('name')->values();
        } else {
            $museums = $allMuseums->sortBy('locality')->sortBy('name')->values();
        }

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
