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
        // No aplicar en comandos de artisan (excepto serve)
        if ($this->app->runningInConsole() && !$this->app->runningUnitTests()) {
            $command = $_SERVER['argv'][1] ?? '';
            if ($command !== 'serve') {
                return;
            }
        }

        try {
            // Configurar el nombre de la aplicación dinámicamente
            $appName = SettingsHelper::getAppName();
            Config::set('app.name', $appName);
            
            // Configurar el registro de usuarios dinámicamente
            $registrationEnabled = SettingsHelper::isUserRegistrationEnabled();
            Config::set('app.registration_enabled', $registrationEnabled);
            
            // Configurar verificación de email
            $emailVerificationRequired = SettingsHelper::isEmailVerificationRequired();
            Config::set('app.email_verification_required', $emailVerificationRequired);
            
            // Configurar zona horaria por defecto
            $timezone = SettingsHelper::getDefaultTimezone();
            Config::set('app.timezone', $timezone);
            
        } catch (\Exception $e) {
            // Si hay error al acceder a la BD (ej: migraciones), usar valores por defecto
            logger('Settings not available, using defaults: ' . $e->getMessage());
        }
    }
}
