<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(config('app.url') . '/api/password/reset/' . $this->token);

        return (new MailMessage)
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->action('Reset Password', $url)
                    ->line('If you did not request a password reset, no further action is required.');
    }
}
