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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Información General
            $table->string('app_name')->default('Laravel Template');
            $table->text('app_description')->nullable();
            $table->string('app_logo')->nullable();
            $table->string('app_favicon')->nullable();
            
            // Configuración de Contacto
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('contact_address')->nullable();
            
                        // Configuración del panel administrativo
            $table->string('admin_language', 5)->default('es');
            
            // Configuración de contenido multiidioma
            $table->json('available_languages')->nullable();
            $table->string('default_timezone', 50)->default('Europe/Madrid');
            $table->string('date_format', 20)->default('d/m/Y');
            
            // Configuración de Email
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();
            $table->boolean('email_notifications_enabled')->default(true);
            
            // Configuración de Seguridad
            $table->boolean('user_registration_enabled')->default(true);
            $table->boolean('email_verification_required')->default(false);
            
            // Configuración de Apariencia
            $table->string('default_theme')->default('light');
            $table->json('custom_colors')->nullable();
            
            // Configuración del Sistema
            $table->boolean('maintenance_mode')->default(false);
            $table->boolean('detailed_logging')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
