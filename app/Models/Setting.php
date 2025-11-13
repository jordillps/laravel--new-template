<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'default_theme',
        'custom_colors',
        'maintenance_mode',
        'detailed_logging',
        'posts_per_page',
    ];

    protected $casts = [
        'available_languages' => 'array',
        'custom_colors' => 'array',
        'email_notifications_enabled' => 'boolean',
        'user_registration_enabled' => 'boolean',
        'email_verification_required' => 'boolean',
        'maintenance_mode' => 'boolean',
        'detailed_logging' => 'boolean',
        'posts_per_page' => 'integer',
    ];

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
            'default_theme' => 'light',
            'maintenance_mode' => false,
            'detailed_logging' => false,
            'posts_per_page' => 10,
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
        return $settings;
    }
}
