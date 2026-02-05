<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'nombre_apellidos',
        'username',
        'email',
        'fecha_nacimiento',
        'hospedaje_favorito',
        'tipo_comida',
        'actividades',
        'tipo_viaje',
        'profile_photo',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relación: Un usuario tiene muchos planes
     */
    public function planes()
    {
        return $this->hasMany(Plan::class, 'user_id');
    }
}
