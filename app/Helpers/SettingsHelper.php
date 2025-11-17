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
     * Obtiene el nombre de la aplicación desde la configuración
     */
    public static function getAppName(): string
    {
        return self::get('app_name', config('app.name', 'Laravel Template'));
    }

    /**
     * Obtiene la URL del logo de la aplicación
     */
    public static function getAppLogo(): ?string
    {
        $logo = self::get('app_logo');
        return $logo ? asset('media/logos/' . $logo) : null;
    }

    /**
     * Obtiene la URL del favicon de la aplicación
     */
    public static function getAppFavicon(): ?string
    {
        $favicon = self::get('app_favicon');
        return $favicon ? asset('media/logos/' . $favicon) : null;
    }

    /**
     * Establece un valor de configuración y limpia su cache
     */
    public static function set(string $key, $value)
    {
        $setting = Setting::first();
        if ($setting) {
            $setting->{$key} = $value;
            $setting->save();
            // Limpiar cache específico del valor actualizado
            Cache::forget("setting_{$key}");
        }
        return $setting;
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

    /**
     * Limpia el cache de una configuración específica
     */
    public static function clearCacheFor(string $key): void
    {
        Cache::forget("setting_{$key}");
    }
}