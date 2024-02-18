<?php

declare(strict_types=1);

namespace App\Domain\Users\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

use function base_path;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::channel('users.{id}', function ($user, $id) {
            return $user->id === $id;
        });
    }
}
