<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixProvinceEncoding extends Command
{
    protected $signature = 'fix:province-encoding';
    protected $description = 'Corrige la codificación incorrecta de provincias en las tablas públicas';

    public function handle()
    {
        $corrections = [
            '?vila' => 'Ávila',
            'Le?n' => 'León',
        ];

        $tables = ['public_hotels', 'public_restaurants', 'public_museums', 'public_festivals'];

        foreach ($tables as $table) {
            foreach ($corrections as $broken => $correct) {
                DB::table($table)->where('province', $broken)->update(['province' => $correct]);
                $this->info("Actualizado $table: $broken → $correct");
            }
        }

        $this->info('Codificación de provincias corregida.');
    }
}
