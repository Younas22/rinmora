<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(protected string $token)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $frontendUrl = rtrim(config('services.frontend.url'), '/');
        $resetUrl = sprintf(
            '%s/reset-password?token=%s&email=%s',
            $frontendUrl,
            $this->token,
            urlencode($notifiable->getEmailForPasswordReset())
        );

        return (new MailMessage)
            ->subject('Reset Your Rinmora Password')
            ->view('emails.customer-reset-password', [
                'name' => $notifiable->first_name,
                'resetUrl' => $resetUrl,
                'expireMinutes' => config('auth.passwords.users.expire', 60),
            ]);
    }
}
