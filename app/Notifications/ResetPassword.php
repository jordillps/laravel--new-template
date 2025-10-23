<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends BaseResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('custom.password.reset', ['token' => $this->token]) . '?email=' . urlencode($notifiable->email));

        return (new MailMessage)
            ->subject(__('Reset Password'))
            ->greeting(__('Hello :name!', ['name' => $notifiable->name]))
            ->line(__('You are receiving this email because we received a password reset request for your account.'))
            ->action(__('Reset Password Button'), $url)
            ->line(__('This password reset link will expire in :expire minutes.', [
                'expire' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60)
            ]))
            ->line(__('If you did not request a password reset, no further action is required.'))
            ->salutation(__('Regards') . ',')
            ->salutation(__('The :app_name Team', ['app_name' => config('app.name')]));
    }
}