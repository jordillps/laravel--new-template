<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurar las notificaciones de verificación de email en español
        \Illuminate\Auth\Notifications\VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Verifica tu dirección de correo electrónico')
                ->greeting('¡Hola ' . $notifiable->name . '!')
                ->line('Gracias por registrarte en ' . config('app.name') . '.')
                ->line('Por favor, haz clic en el botón de abajo para verificar tu dirección de correo electrónico.')
                ->action('Verificar dirección de correo', $url)
                ->line('Este enlace de verificación expirará en ' . config('auth.verification.expire', 60) . ' minutos.')
                ->line('Si no creaste una cuenta, no es necesario realizar ninguna acción.')
                ->salutation('Saludos,')
                ->salutation('El equipo de ' . config('app.name'));
        });

        // Configurar las notificaciones de restablecimiento de contraseña en español
        \Illuminate\Auth\Notifications\ResetPassword::toMailUsing(function ($notifiable, $token) {
            // Usar nuestra ruta personalizada que no tiene problemas de firma
            $url = url(route('custom.password.reset', ['token' => $token]) . '?email=' . urlencode($notifiable->email));

            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Restablecer contraseña')
                ->greeting('¡Hola ' . $notifiable->name . '!')
                ->line('Has recibido este correo porque hemos recibido una solicitud de restablecimiento de contraseña para tu cuenta.')
                ->action('Restablecer contraseña', $url)
                ->line('Este enlace de restablecimiento de contraseña expirará en ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60) . ' minutos.')
                ->line('Si no solicitaste el restablecimiento de contraseña, no es necesario realizar ninguna acción.')
                ->salutation('Saludos,')
                ->salutation('El equipo de ' . config('app.name'));
        });
    }
}
