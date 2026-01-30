<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'provincia', 'municipio', 'start_date', 'end_date', 'days', 'items'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'items' => 'array',
    ];
}
