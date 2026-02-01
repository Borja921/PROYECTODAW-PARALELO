<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Primero, crear una nueva tabla con la estructura deseada
        Schema::create('planes_new', function (Blueprint $table) {
            $table->id('numero_plan');
            $table->string('nombre_plan');
            $table->unsignedBigInteger('usuario_id');
            $table->string('provincia');
            $table->string('municipio');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('days')->unsigned();
            $table->json('items')->nullable();
            $table->json('listado_hoteles')->nullable();
            $table->json('listado_restaurantes')->nullable();
            $table->json('listado_museos')->nullable();
            $table->json('listado_fiestas')->nullable();
            $table->timestamps();
            
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
        });

        // Migrar datos existentes si los hay
        if (Schema::hasTable('plans')) {
            $existingPlans = \DB::table('plans')->get();
            foreach ($existingPlans as $plan) {
                \DB::table('planes_new')->insert([
                    'nombre_plan' => 'Plan ' . $plan->id, // Nombre por defecto
                    'usuario_id' => $plan->user_id ?? 1, // Usuario por defecto si es null
                    'provincia' => $plan->provincia,
                    'municipio' => $plan->municipio,
                    'start_date' => $plan->start_date,
                    'end_date' => $plan->end_date,
                    'days' => $plan->days,
                    'items' => $plan->items,
                    'listado_hoteles' => null,
                    'listado_restaurantes' => null,
                    'listado_museos' => null,
                    'listado_fiestas' => null,
                    'created_at' => $plan->created_at,
                    'updated_at' => $plan->updated_at,
                ]);
            }
        }

        // Eliminar la tabla antigua y renombrar la nueva
        Schema::dropIfExists('plans');
        Schema::rename('planes_new', 'plans');
    }

    public function down()
    {
        // Crear la tabla original
        Schema::create('plans_old', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provincia');
            $table->string('municipio');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('days')->unsigned();
            $table->json('items')->nullable();
            $table->timestamps();
        });

        // Migrar datos de vuelta
        $existingPlans = \DB::table('plans')->get();
        foreach ($existingPlans as $plan) {
            \DB::table('plans_old')->insert([
                'user_id' => $plan->usuario_id,
                'provincia' => $plan->provincia,
                'municipio' => $plan->municipio,
                'start_date' => $plan->start_date,
                'end_date' => $plan->end_date,
                'days' => $plan->days,
                'items' => $plan->items,
                'created_at' => $plan->created_at,
                'updated_at' => $plan->updated_at,
            ]);
        }

        // Eliminar la tabla nueva y renombrar la antigua
        Schema::dropIfExists('plans');
        Schema::rename('plans_old', 'plans');
    }
};