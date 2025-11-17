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
        // La columna 'two_factor_enabled' nunca existió en la tabla settings
        // por lo que no hay nada que eliminar
        if (Schema::hasColumn('settings', 'two_factor_enabled')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('two_factor_enabled');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('two_factor_enabled')->default(false);
        });
    }
};
