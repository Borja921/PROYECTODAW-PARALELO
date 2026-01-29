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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('province');
            $table->string('region');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->integer('visitors_count')->default(0);
            $table->string('climate_type')->nullable(); // Playa, Montaña, Ciudad
            $table->text('attractions')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
