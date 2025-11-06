<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPasswordBase implements ShouldQueue
{
    use Queueable;

    /**
     * The password reset token.
     */
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        // Para testing, usar una URL simple
        $testUrl = config('app.url') . '/admin/password-reset/reset?token=' . $this->token;

        return $this->buildMailMessage($testUrl);
    }

    /**
     * Build the mail message.
     */
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('🔑 Restablecer Contraseña')
            ->greeting('¡Hola!')
            ->line('Recibiste este email porque solicitaste restablecer la contraseña de tu cuenta en **' . config('app.name') . '**.')
            ->action('🔓 Restablecer Contraseña', $url)
            ->line('Este enlace expirará en 60 minutos.')
            ->line('Si no solicitaste restablecer tu contraseña, no es necesario que hagas nada.')
            ->salutation('Saludos,')
            ->salutation('El equipo de ' . config('app.name'));
    }
}