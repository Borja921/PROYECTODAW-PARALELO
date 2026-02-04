<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->string('hospedaje_favorito')->nullable()->after('fecha_nacimiento');
            $table->string('tipo_comida')->nullable()->after('hospedaje_favorito');
            $table->string('actividades')->nullable()->after('tipo_comida');
            $table->string('tipo_viaje')->nullable()->after('actividades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn(['hospedaje_favorito', 'tipo_comida', 'actividades', 'tipo_viaje']);
        });
    }
};
