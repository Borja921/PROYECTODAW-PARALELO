<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'id_user', 'provincia', 'municipio', 'start_date', 'end_date', 'days', 'items', 'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'items' => 'array',
    ];

    public static function userColumn(): string
    {
        $table = (new static())->getTable();
        if (Schema::hasColumn($table, 'id_user')) {
            return 'id_user';
        }
        return 'user_id';
    }
}
