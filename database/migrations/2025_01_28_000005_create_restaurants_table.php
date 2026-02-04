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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->string('name');
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('cuisine_type'); // Española, Italiana, Francesa, etc.
            $table->decimal('price_level', 3, 1); // €, €€, €€€, €€€€
            $table->decimal('rating', 3, 1)->default(4.0);
            $table->string('image')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('opening_hours')->nullable();
            $table->boolean('has_reservations')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
