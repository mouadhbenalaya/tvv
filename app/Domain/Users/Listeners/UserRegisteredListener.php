<?php

namespace App\Domain\Users\Listeners;

use App\Domain\Users\Notifications\VerifyEmailNotification;
use App\Infrastructure\Abstracts\Listener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;

class UserRegisteredListener extends Listener
{
    public function __construct()
    {
        $this->onQueue('notifications');
    }

    /**
     * Handle the event.
     *
     * @param Registered $event
     *
     * @throws \Exception
     */
    public function handle(Registered $event): void
    {
        Notification::send(
            $event->user,
            /** @phpstan-ignore-next-line */
            new VerifyEmailNotification($event->user->email_token_confirmation)
        );
    }
}
