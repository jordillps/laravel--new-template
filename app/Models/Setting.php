<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Helpers\SettingsHelper;

class Setting extends Model
{
    protected $fillable = [
        'app_name',
        'app_description',
        'app_logo',
        'app_favicon',
        'contact_email',
        'contact_phone',
        'contact_address',
        'admin_language',
        'available_languages',
        'default_timezone',
        'date_format',
        'mail_from_address',
        'mail_from_name',
        'email_notifications_enabled',
        'user_registration_enabled',
        'email_verification_required',
        'custom_colors',
        'maintenance_mode',
        'detailed_logging',
    ];

    protected $casts = [
        'available_languages' => 'array',
        'custom_colors' => 'array',
        'email_notifications_enabled' => 'boolean',
        'user_registration_enabled' => 'boolean',
        'email_verification_required' => 'boolean',
        'maintenance_mode' => 'boolean',
        'detailed_logging' => 'boolean',
    ];

    /**
     * Boot del modelo para eventos
     */
    protected static function boot()
    {
        parent::boot();

        // Limpiar cache automáticamente cuando se actualiza la configuración
        static::updated(function ($setting) {
            // Manejar eliminación de logo antiguo
            if ($setting->wasChanged('app_logo') && $setting->getOriginal('app_logo')) {
                $oldLogo = $setting->getOriginal('app_logo');
                $logoPath = public_path('media/logos/' . $oldLogo);
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                }
            }
            
            // Manejar eliminación de favicon antiguo
            if ($setting->wasChanged('app_favicon') && $setting->getOriginal('app_favicon')) {
                $oldFavicon = $setting->getOriginal('app_favicon');
                $faviconPath = public_path('media/logos/' . $oldFavicon);
                if (file_exists($faviconPath)) {
                    unlink($faviconPath);
                }
            }
            
            // Limpiar cache de todas las configuraciones
            SettingsHelper::clearCache();
            
            // Si se actualiza el nombre de la app, actualizar también la configuración global
            if ($setting->wasChanged('app_name') && $setting->app_name) {
                config(['app.name' => $setting->app_name]);
            }
        });

        // También limpiar cache al crear
        static::created(function ($setting) {
            SettingsHelper::clearCache();
        });

        // Limpiar archivos al eliminar configuración
        static::deleting(function ($setting) {
            // Eliminar logo si existe
            if ($setting->app_logo) {
                $logoPath = public_path('media/logos/' . $setting->app_logo);
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                }
            }
            
            // Eliminar favicon si existe
            if ($setting->app_favicon) {
                $faviconPath = public_path('media/logos/' . $setting->app_favicon);
                if (file_exists($faviconPath)) {
                    unlink($faviconPath);
                }
            }
        });
    }

    /**
     * Obtiene la configuración general (singleton)
     */
    public static function getSettings()
    {
        return static::firstOrCreate([], [
            'app_name' => 'Laravel Template',
            'available_languages' => ['es', 'en'],
            'default_language' => 'es',
            'default_timezone' => 'Europe/Madrid',
            'date_format' => 'd/m/Y',
            'email_notifications_enabled' => true,
            'user_registration_enabled' => true,
            'email_verification_required' => false,
            'maintenance_mode' => false,
            'detailed_logging' => false,
        ]);
    }

    /**
     * Obtiene un valor específico de configuración
     */
    public static function get($key, $default = null)
    {
        $settings = static::getSettings();
        return $settings->$key ?? $default;
    }

    /**
     * Establece un valor específico de configuración
     */
    public static function set($key, $value)
    {
        $settings = static::getSettings();
        $settings->$key = $value;
        $settings->save();
        
        // El cache se limpia automáticamente en el evento 'updated'
        return $settings;
    }
}
