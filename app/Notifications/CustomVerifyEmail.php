<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmailBase implements ShouldQueue
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return $this->buildMailMessage($verificationUrl);
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'filament.admin.auth.email-verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Build the mail message.
     */
    protected function buildMailMessage($url): MailMessage
    {
        // Para testing, usar una URL simple
        $testUrl = config('app.url') . '/admin/email-verification/verify/test/hash';
        
        return (new MailMessage)
            ->subject('🔐 Verificar tu Dirección de Email')
            ->greeting('¡Hola!')
            ->line('Te damos la bienvenida a **' . config('app.name') . '**. Por favor, verifica tu dirección de email haciendo clic en el botón de abajo.')
            ->action('✅ Verificar Email', $testUrl)
            ->line('Este enlace expirará en 60 minutos.')
            ->line('Si no creaste una cuenta, no es necesario que hagas nada.')
            ->salutation('Saludos,')
            ->salutation('El equipo de ' . config('app.name'));
    }
}