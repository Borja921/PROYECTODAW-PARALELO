<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicHotel extends Model
{
    use SoftDeletes;

    protected $table = 'public_hotels';

    protected $fillable = [
        'name',
        'locality',
        'province',
        'address',
        'postal_code',
        'phone',
        'email',
        'website',
        'classification',
        'stars',
        'num_rooms',
        'image_url',
        'description',
        'latitude',
        'longitude',
        'rating',
        'reviews_count',
        'amenities',
        'is_active',
        'source',
    ];

    protected $casts = [
        'amenities' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
        'rating' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * Obtener hoteles por localidad
     */
    public static function byLocality($locality)
    {
        return self::where('locality', $locality)->where('is_active', true)->get();
    }

    /**
     * Obtener todas las localidades disponibles
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
