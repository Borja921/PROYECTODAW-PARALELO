<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('public_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('locality'); // Localidad/ciudad
            $table->string('province')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('classification')->nullable(); // Clasificación hotelera
            $table->integer('stars')->nullable(); // 1-5 estrellas
            $table->integer('num_rooms')->nullable();
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('rating', 3, 1)->default(4.0);
            $table->integer('reviews_count')->default(0);
            $table->json('amenities')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('source')->default('opendata'); // Fuente de datos
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para búsquedas rápidas
            $table->index('locality');
            $table->index('province');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_hotels');
    }
};
