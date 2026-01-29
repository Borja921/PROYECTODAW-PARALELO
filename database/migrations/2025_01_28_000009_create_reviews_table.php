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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->morphs('reviewable'); // polimórfica para hoteles, restaurantes, atracciones, etc.
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->date('visit_date')->nullable();
            $table->integer('helpful_count')->default(0);
            $table->boolean('is_verified_purchase')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
