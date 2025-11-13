<?php

namespace App\Http\Controllers;

use App\Helpers\SettingsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Cambiar idioma de la sesión
     */
    public function switch(Request $request, string $locale)
    {
        // Verificar que el idioma esté en la lista de disponibles
        $availableLanguages = SettingsHelper::getAvailableLanguages();
        
        if (!in_array($locale, $availableLanguages)) {
            return back()->with('error', __('Idioma no disponible'));
        }

        // Guardar en sesión para sobrescribir la configuración por defecto
        Session::put('locale', $locale);

        return back()->with('success', __('Idioma cambiado correctamente'));
    }

    /**
     * Resetear idioma a la configuración por defecto
     */
    public function reset()
    {
        Session::forget('locale');
        
        return back()->with('success', __('Idioma restaurado a configuración por defecto'));
    }
}