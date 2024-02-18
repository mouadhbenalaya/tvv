<?php

namespace App\Domain\Users\Notifications\Registration;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserCreatedSuccessfully extends Notification
{
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('User created'))
            ->line(__('User account for you is created.'));
    }
}
