<?php

namespace App\Domain\Users\Notifications\Registration;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserEmailConfirmation extends Notification
{
    public static ?\Closure $createUrlCallback = null;

    public function __construct(private readonly string $token)
    {
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return $this->buildMailMessage($this->resetUrl($notifiable));
    }

    protected function resetUrl(mixed $notifiable): string
    {
        if (null === static::$createUrlCallback) {
            throw new \RuntimeException('Missing URL callback.');
        }

        return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
    }

    protected function buildMailMessage(string $url): MailMessage
    {
        return (new MailMessage())
            ->subject('Verify Email Address')
            ->line('Click the button below to verify your email address.')
            ->action('Verify Email Address', $url);
    }

    public static function createUrlUsing(mixed $callback): void
    {
        static::$createUrlCallback = $callback;
    }
}
