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
        Schema::create('plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_plan_id')->constrained('travel_plans')->onDelete('cascade');
            $table->foreignId('hotel_id')->nullable()->constrained('hotels')->onDelete('set null');
            $table->foreignId('restaurant_id')->nullable()->constrained('restaurants')->onDelete('set null');
            $table->foreignId('attraction_id')->nullable()->constrained('attractions')->onDelete('set null');
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('type'); // hotel, restaurante, atracción, otro
            $table->text('notes')->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->integer('day_number');
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_items');
    }
};
