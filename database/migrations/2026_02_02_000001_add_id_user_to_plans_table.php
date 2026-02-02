<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            if (!Schema::hasColumn('plans', 'id_user')) {
                $table->unsignedBigInteger('id_user')->nullable()->after('user_id');
                $table->foreign('id_user')->references('id')->on('usuario')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'id_user')) {
                $table->dropForeign(['id_user']);
                $table->dropColumn('id_user');
            }
        });
    }
};
