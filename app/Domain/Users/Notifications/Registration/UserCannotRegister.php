<?php

namespace App\Domain\Users\Notifications\Registration;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCannotRegister extends Notification
{
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Registration failed'))
            ->line(__('The email address with a given type is already in use.'));
    }
}
