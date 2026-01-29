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
        Schema::create('public_museums', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('locality')->index();
            $table->string('province')->index();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('museum_type'); // Museo, Galería, Centro Cultural, etc.
            $table->text('description')->nullable();
            $table->integer('num_rooms')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('rating', 3, 1)->default(4.0);
            $table->integer('reviews_count')->default(0);
            $table->json('amenities')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('source')->default('opendata');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['locality', 'province']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_museums');
    }
};
