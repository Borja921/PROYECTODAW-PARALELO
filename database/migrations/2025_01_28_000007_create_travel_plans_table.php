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
        Schema::create('travel_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('num_travelers')->default(1);
            $table->decimal('budget', 10, 2)->nullable();
            $table->enum('status', ['planning', 'confirmed', 'in_progress', 'completed'])->default('planning');
            $table->integer('completion_percentage')->default(0);
            $table->boolean('is_public')->default(false);
            $table->decimal('rating', 3, 1)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_plans');
    }
};
