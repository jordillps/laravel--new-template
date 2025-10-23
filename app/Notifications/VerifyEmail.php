<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(__('Verify your email address'))
            ->greeting(__('Hello :name!', ['name' => $notifiable->name]))
            ->line(__('Thanks for registering with :app_name.', ['app_name' => config('app.name')]))
            ->line(__('Please click the button below to verify your email address.'))
            ->action(__('Verify Email Address'), $verificationUrl)
            ->line(__('This verification link will expire in :expire minutes.', [
                'expire' => config('auth.verification.expire', 60)
            ]))
            ->line(__('If you did not create an account, no further action is required.'))
            ->salutation(__('Regards') . ',')
            ->salutation(__('The :app_name Team', ['app_name' => config('app.name')]));
    }
}