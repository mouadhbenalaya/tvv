<?php

namespace App\Domain\Users\Notifications\Registration;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegisteredSuccessfully extends Notification
{
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Registration completed'))
            ->line(__('Your registration process has been completed.'));
    }
}
