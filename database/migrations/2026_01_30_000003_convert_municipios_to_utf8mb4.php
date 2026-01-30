<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Convertir tabla a utf8mb4 para soportar acentos y caracteres especiales
        DB::statement("ALTER TABLE municipios CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    public function down()
    {
        // Volver a utf8 (no recomendado) si se requiere revertir
        DB::statement("ALTER TABLE municipios CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci");
    }
};
