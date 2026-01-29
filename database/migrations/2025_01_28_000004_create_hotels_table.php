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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->string('name');
            $table->string('location');
            $table->text('description')->nullable();
            $table->integer('stars')->default(3); // 1-5 estrellas
            $table->decimal('price_per_night', 8, 2);
            $table->decimal('rating', 3, 1)->default(4.0);
            $table->string('image')->nullable();
            $table->integer('rooms_available')->default(10);
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->text('amenities')->nullable(); // JSON
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
        Schema::dropIfExists('hotels');
    }
};
