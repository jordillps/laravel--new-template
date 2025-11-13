<?php

namespace App\Observers;

use App\Models\Setting;
use App\Helpers\SettingsHelper;
use Illuminate\Support\Facades\App;

class SettingObserver
{
    /**
     * Handle the Setting "created" event.
     */
    public function created(Setting $setting): void
    {
        $this->clearCacheAndUpdateConfig();
    }

    /**
     * Handle the Setting "updated" event.
     */
    public function updated(Setting $setting): void
    {
        $this->clearCacheAndUpdateConfig();
        
        // Si se cambió el idioma del admin, actualizar la configuración inmediatamente
        if ($setting->isDirty('admin_language')) {
            $newLanguage = $setting->admin_language;
            $adminLanguages = ['es', 'ca', 'en'];
            if ($newLanguage && in_array($newLanguage, $adminLanguages)) {
                App::setLocale($newLanguage);
            }
        }

        // Si se cambió la zona horaria, actualizarla
        if ($setting->isDirty('default_timezone')) {
            $newTimezone = $setting->default_timezone;
            if ($newTimezone) {
                config(['app.timezone' => $newTimezone]);
                date_default_timezone_set($newTimezone);
            }
        }

        // Si se cambió el nombre de la aplicación, actualizarlo
        if ($setting->isDirty('app_name')) {
            $newAppName = $setting->app_name;
            if ($newAppName) {
                config(['app.name' => $newAppName]);
            }
        }
    }

    /**
     * Handle the Setting "deleted" event.
     */
    public function deleted(Setting $setting): void
    {
        $this->clearCacheAndUpdateConfig();
    }

    /**
     * Limpiar cache y actualizar configuración
     */
    private function clearCacheAndUpdateConfig(): void
    {
        SettingsHelper::clearCache();
        
        // Limpiar cache de configuración de Laravel también
        try {
            \Illuminate\Support\Facades\Artisan::call('config:clear');
        } catch (\Exception $e) {
            // Silencioso si falla
        }
    }
}
