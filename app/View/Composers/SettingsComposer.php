<?php

namespace App\View\Composers;

use App\Helpers\SettingsHelper;
use Illuminate\View\View;

class SettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        try {
            $view->with([
                'appName' => SettingsHelper::getAppName(),
                'appLogo' => SettingsHelper::getAppLogo(),
                'appFavicon' => SettingsHelper::getAppFavicon(),
            ]);
        } catch (\Exception $e) {
            // Si hay error, usar valores por defecto
            $view->with([
                'appName' => 'Laravel Template',
                'appLogo' => null,
                'appFavicon' => null,
            ]);
        }
    }
}