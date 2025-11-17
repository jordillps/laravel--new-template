<?php

namespace App\Providers;

use App\Helpers\SettingsHelper;
use App\Models\Setting;
use App\Observers\SettingObserver;
use App\View\Composers\SettingsComposer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurar reglas de contraseña globales
        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->isProduction()
                        ? $rule->mixedCase()->uncompromised()
                        : $rule;
        });

        // Register observer
        Setting::observe(SettingObserver::class);

        // Register view composer for global access to settings
        View::composer('*', SettingsComposer::class);

        // Aplicar configuraciones dinámicas desde Settings
        $this->applyDynamicSettings();
    }

    /**
     * Aplica configuraciones dinámicas desde la base de datos
     */
    private function applyDynamicSettings(): void
    {
        try {
            // Solo aplicar si las tablas existen (evita errores en migraciones)
            if (!\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                return;
            }

            // Configurar idioma del admin
            $adminLanguage = SettingsHelper::getAdminLanguage();
            $adminLanguages = ['es', 'ca', 'en'];
            if ($adminLanguage && in_array($adminLanguage, $adminLanguages)) {
                App::setLocale($adminLanguage);
            }

            // Configurar zona horaria
            $timezone = SettingsHelper::getDefaultTimezone();
            if ($timezone) {
                config(['app.timezone' => $timezone]);
                date_default_timezone_set($timezone);
            }

            // Configurar nombre de la aplicación
            $appName = SettingsHelper::get('app_name');
            if ($appName) {
                config(['app.name' => $appName]);
            }
            
        } catch (\Exception $e) {
            // Silencioso en caso de error (ej: durante migraciones)
            \Illuminate\Support\Facades\Log::debug('Settings not available during bootstrap: ' . $e->getMessage());
        }
    }
}
