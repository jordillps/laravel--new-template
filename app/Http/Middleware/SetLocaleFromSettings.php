<?php

namespace App\Http\Middleware;

use App\Helpers\SettingsHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Prioridades para establecer el idioma:
        // 1. Sesión del usuario (si ha cambiado manualmente)
        // 2. Configuración de la aplicación (desde Settings)
        // 3. Idioma por defecto de Laravel

        $locale = Session::get('locale');
        
        if (!$locale) {
            // Obtener idioma del admin desde configuraciones
            $locale = SettingsHelper::getAdminLanguage();
            
            // Verificar que el idioma del admin sea válido
            $adminLanguages = ['es', 'ca', 'en'];
            if (!in_array($locale, $adminLanguages)) {
                $locale = 'es';
            }
        }

        // Establecer el idioma para la aplicación
        App::setLocale($locale);
        
        // Establecer zona horaria
        $timezone = SettingsHelper::getDefaultTimezone();
        if ($timezone) {
            config(['app.timezone' => $timezone]);
            date_default_timezone_set($timezone);
        }

        return $next($request);
    }
}