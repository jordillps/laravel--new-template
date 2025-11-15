<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Obtiene un valor de configuración con cache
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = Setting::first();
            return $setting ? ($setting->{$key} ?? $default) : $default;
        });
    }

    /**
     * Verifica si el registro de usuarios está habilitado
     */
    public static function isUserRegistrationEnabled(): bool
    {
        return (bool) self::get('user_registration_enabled', true);
    }

    /**
     * Verifica si la verificación de email es requerida
     */
    public static function isEmailVerificationRequired(): bool
    {
        return (bool) self::get('email_verification_required', false);
    }

    /**
     * Verifica si está en modo mantenimiento
     */
    public static function isMaintenanceMode(): bool
    {
        return (bool) self::get('maintenance_mode', false);
    }

    /**
     * Obtiene el idioma del admin
     */
    public static function getAdminLanguage(): string
    {
        return self::get('admin_language', 'es');
    }

    /**
     * Obtiene los idiomas disponibles
     */
    public static function getAvailableLanguages(): array
    {
        $languages = self::get('available_languages', ['es', 'en']);
        return is_array($languages) ? $languages : ['es', 'en'];
    }

    /**
     * Obtiene la zona horaria por defecto
     */
    public static function getDefaultTimezone(): string
    {
        return self::get('default_timezone', 'Europe/Madrid');
    }

    /**
     * Limpia el cache de configuraciones
     */
    public static function clearCache(): void
    {
        $setting = Setting::first();
        if ($setting) {
            foreach ($setting->getFillable() as $key) {
                Cache::forget("setting_{$key}");
            }
        }
    }
}