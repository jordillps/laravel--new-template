<?php

namespace App\Http\Middleware;

use App\Helpers\SettingsHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Verificar si está en modo mantenimiento
            if (SettingsHelper::isMaintenanceMode()) {
                // Permitir acceso a rutas de admin para poder desactivar el modo
                if ($request->is('admin*')) {
                    return $next($request);
                }
                
                // Mostrar página de mantenimiento para otros usuarios
                return response()->view('maintenance', [], 503);
            }
        } catch (\Exception $e) {
            // Si hay error al acceder a configuraciones, continuar normal
            logger('Error checking maintenance mode: ' . $e->getMessage());
        }

        return $next($request);
    }
}
