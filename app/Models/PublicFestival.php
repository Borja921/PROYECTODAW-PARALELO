<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicFestival extends Model
{
    use SoftDeletes;

    protected $table = 'public_festivals';

    protected $fillable = [
        'name', 'locality', 'province', 'address', 'postal_code', 'phone', 'email', 'website',
        'festival_type', 'description', 'start_date', 'end_date', 'time', 'price', 'latitude', 
        'longitude', 'rating', 'reviews_count', 'amenities', 'is_active', 'source'
    ];

    protected $casts = [
        'amenities' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
        'rating' => 'float',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Filtrar festivales por localidad
     */
    public static function byLocality($locality)
    {
        return self::where('locality', $locality)
            ->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->orderBy('name')
            ->get();
    }

    /**
     * Obtener localidades con conteo
     */
    public static function getLocalitiesWithCount()
    {
        return self::where('is_active', true)
            ->selectRaw('locality, COUNT(*) as count')
            ->groupBy('locality')
            ->orderBy('locality')
            ->get();
    }

    /**
     * Obtener provincias disponibles
     */
    public static function getProvinces()
    {
        return self::where('is_active', true)
            ->distinct()
            ->pluck('province')
            ->filter()
            ->sort()
            ->values();
    }
}
