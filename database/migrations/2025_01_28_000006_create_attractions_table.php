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
        Schema::create('attractions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->string('name');
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('type'); // Museo, Monumento, Parque, etc.
            $table->decimal('entrance_fee', 8, 2)->nullable();
            $table->decimal('rating', 3, 1)->default(4.0);
            $table->string('image')->nullable();
            $table->string('website')->nullable();
            $table->string('opening_hours')->nullable();
            $table->text('accessibility_info')->nullable();
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
        Schema::dropIfExists('attractions');
    }
};
