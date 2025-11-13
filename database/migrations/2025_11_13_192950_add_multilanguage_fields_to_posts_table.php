<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Cambiar campos de texto simple a JSON multiidioma
            $table->json('title_multilang')->nullable()->after('title');
            $table->json('slug_multilang')->nullable()->after('slug');
            $table->json('excerpt_multilang')->nullable()->after('excerpt');
            $table->json('content_multilang')->nullable()->after('content');
        });

        // Migrar datos existentes
        DB::statement("
            UPDATE posts 
            SET 
                title_multilang = JSON_OBJECT('es', title),
                slug_multilang = JSON_OBJECT('es', slug),
                excerpt_multilang = JSON_OBJECT('es', excerpt),
                content_multilang = JSON_OBJECT('es', content)
            WHERE title IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title_multilang', 'slug_multilang', 'excerpt_multilang', 'content_multilang']);
        });
    }
};
