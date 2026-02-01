<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $primaryKey = 'numero_plan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'numero_plan',
        'nombre_plan', 
        'usuario_id', 
        'provincia', 
        'municipio', 
        'start_date', 
        'end_date', 
        'days', 
        'items',
        'listado_hoteles',
        'listado_restaurantes',
        'listado_museos',
        'listado_fiestas'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'items' => 'array',
        'listado_hoteles' => 'array',
        'listado_restaurantes' => 'array',
        'listado_museos' => 'array',
        'listado_fiestas' => 'array',
    ];

    /**
     * Relación con el usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
