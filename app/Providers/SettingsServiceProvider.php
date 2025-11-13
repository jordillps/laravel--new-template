<?php

namespace App\Providers;

use App\Helpers\SettingsHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Aplicar configuraciones dinámicamente
        if ($this->app->runningInConsole()) {
            return; // No aplicar en comandos de artisan
        }

        try {
            // Configurar el registro de usuarios dinámicamente
            $registrationEnabled = SettingsHelper::isUserRegistrationEnabled();
            Config::set('app.registration_enabled', $registrationEnabled);
            
            // Configurar verificación de email
            $emailVerificationRequired = SettingsHelper::isEmailVerificationRequired();
            Config::set('app.email_verification_required', $emailVerificationRequired);
            
            // Configurar otras configuraciones de aplicación
            $appName = SettingsHelper::get('app_name', 'Laravel Template');
            Config::set('app.name', $appName);
            
        } catch (\Exception $e) {
            // Si hay error al acceder a la BD (ej: migraciones), ignorar
            logger('Settings not available: ' . $e->getMessage());
        }
    }
}
