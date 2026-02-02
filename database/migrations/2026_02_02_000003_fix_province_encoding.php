<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Corregir provincias mal codificadas en todas las tablas públicas
        $corrections = [
            '?vila' => 'Ávila',
            'Le?n' => 'León',
        ];

        $tables = ['public_hotels', 'public_restaurants', 'public_museums', 'public_festivals'];

        foreach ($tables as $table) {
            foreach ($corrections as $broken => $correct) {
                DB::table($table)->where('province', $broken)->update(['province' => $correct]);
            }
        }
    }

    public function down()
    {
        // Revertir correcciones si es necesario
        $corrections = [
            'Ávila' => '?vila',
            'León' => 'Le?n',
        ];

        $tables = ['public_hotels', 'public_restaurants', 'public_museums', 'public_festivals'];

        foreach ($tables as $table) {
            foreach ($corrections as $correct => $broken) {
                DB::table($table)->where('province', $correct)->update(['province' => $broken]);
            }
        }
    }
};
