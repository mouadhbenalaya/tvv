<?php

namespace App\Domain\Users\Notifications\Registration;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TvtcOperatorCreatedSuccessfully extends Notification
{
    public static ?\Closure $createUrlCallback = null;

    public function __construct(private readonly  string $token)
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
            ->subject(__('Set password notification'))
            ->line(__('You are receiving this email because we created an account for your account and you have to set new password.'))
            ->action(__('Set password'), $url)
            ->line(__('This link will expire in :count minutes.', [
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')
            ]));
    }

    public static function createUrlUsing(mixed $callback): void
    {
        static::$createUrlCallback = $callback;
    }
}
