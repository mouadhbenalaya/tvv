<?php

namespace App\Domain\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function __construct(private string $token)
    {
        $this->onQueue('notifications');
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->markdown('emails.default')
            ->success()
            ->subject(__(':app_name - Confirm your registration', ['app_name' => config('app.name')]))
            ->greeting(__('Welcome to :app_name', ['app_name' => config('app.name')]))
            ->line(__('Click the link below to complete verification:'))
            ->action(__('Verify Email'), url('/user/verify/' . $this->token));
    }
}
