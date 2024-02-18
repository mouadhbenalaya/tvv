<?php

namespace App\Domain\Users\Providers;

use App\Domain\Users\Listeners\Observers\PermissionObserver;
use App\Domain\Users\Listeners\Observers\RoleObserver;
use App\Domain\Users\Listeners\Observers\UserObserver;
use App\Domain\Users\Listeners\UserRegisteredListener;
use App\Domain\Users\Models\Permission;
use App\Domain\Users\Models\Role;
use App\Domain\Users\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        Registered::class => [
            UserRegisteredListener::class,
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        Permission::observe(PermissionObserver::class);
        Role::observe(RoleObserver::class);
        User::observe(UserObserver::class);
    }
}
