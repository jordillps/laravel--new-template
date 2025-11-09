<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Auth\MultiFactor\Email\EmailAuthentication;
use Filament\Panel;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\Navigation\MenuItem;
use Illuminate\Support\Facades\View;


class AdminPanelProvider extends PanelProvider
{
    public function boot(): void
    {
        // La configuración de avatares se maneja automáticamente por la interfaz HasAvatar
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default() // Ensure this method is implemented and returns a valid object
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->registration()
            ->emailVerification()
            ->passwordReset()
            ->multiFactorAuthentication([EmailAuthentication::make()])
            ->colors([
                'primary' => [
                    50 => '236, 253, 245',   // Verde muy claro
                    100 => '209, 250, 229',  // Verde claro pastel
                    200 => '167, 243, 208',  // Verde claro
                    300 => '110, 231, 183',  // Verde suave
                    400 => '52, 211, 153',   // Verde medio-claro
                    500 => '16, 185, 129',   // Verde principal
                    600 => '5, 150, 105',    // Verde medio
                    700 => '4, 120, 87',     // Verde medio-oscuro
                    800 => '6, 95, 70',      // Verde oscuro
                    900 => '6, 78, 59',      // Verde muy oscuro
                    950 => '2, 44, 34',      // Verde casi negro
                ],
                'blue' => [
                    50 => '239, 246, 255',   // Azul muy claro
                    100 => '219, 234, 254',  // Azul claro
                    200 => '191, 219, 254',  // Azul medio-claro
                    300 => '147, 197, 253',  // Azul medio
                    400 => '96, 165, 250',   // Azul
                    500 => '59, 130, 246',   // Azul principal
                    600 => '37, 99, 235',    // Azul medio-oscuro
                    700 => '29, 78, 216',    // Azul oscuro
                    800 => '30, 64, 175',    // Azul muy oscuro
                    900 => '30, 58, 138',    // Azul profundo
                    950 => '23, 37, 84',     // Azul casi negro
                ],
            ])
            ->font('Roboto')
            ->brandLogo(asset('media/logo/logoFormalWeb_8.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('media/logo/logoformalweb.ico'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->resources([
                \BezhanSalleh\FilamentShield\Resources\Roles\RoleResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
