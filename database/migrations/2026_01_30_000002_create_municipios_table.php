<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provincia')->index();
            $table->string('provincia_codigo')->nullable();
            $table->string('municipio')->index();
            $table->string('municipio_codigo')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();

            $table->unique(['provincia', 'municipio'], 'provincia_municipio_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('municipios');
    }
};
