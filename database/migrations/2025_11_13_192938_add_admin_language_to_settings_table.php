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
        Schema::table('settings', function (Blueprint $table) {
            // Solo agregar admin_language si no existe
            if (!Schema::hasColumn('settings', 'admin_language')) {
                $table->string('admin_language', 5)->default('es')->after('contact_address');
            }
            
            // Solo eliminar default_language si existe
            if (Schema::hasColumn('settings', 'default_language')) {
                $table->dropColumn('default_language');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('admin_language');
            $table->string('default_language', 5)->default('es')->after('available_languages');
        });
    }
};
