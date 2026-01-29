<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'nombre_apellidos',
        'username',
        'email',
        'fecha_nacimiento',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
