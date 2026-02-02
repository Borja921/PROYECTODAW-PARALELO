<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id_user');
        });
    }

    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
