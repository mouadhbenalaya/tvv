<?php

namespace App\Application\Providers;

use App\Application\Contracts\AuditLogRepository;
use App\Application\Contracts\ProfileRepository;
use App\Application\Contracts\TmpUserRepository;
use App\Application\Contracts\UserRepository;
use App\Application\Contracts\UserTypeRepository;
use App\Application\Repositories\EloquentAuditLogRepository;
use App\Application\Repositories\EloquentProfileRepository;
use App\Application\Repositories\EloquentTmpUserRepository;
use App\Application\Repositories\EloquentUserRepository;
use App\Application\Repositories\EloquentUserTypeRepository;
use App\Common\Models\AuditLog;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = true;

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, function () {
            return new EloquentUserRepository(new User());
        });
        $this->app->singleton(TmpUserRepository::class, function () {
            return new EloquentTmpUserRepository(new TmpUser());
        });
        $this->app->singleton(UserTypeRepository::class, function () {
            return new EloquentUserTypeRepository(new UserType());
        });
        $this->app->singleton(ProfileRepository::class, function () {
            return new EloquentProfileRepository(new Profile());
        });
        $this->app->singleton(AuditLogRepository::class, function () {
            return new EloquentAuditLogRepository(new AuditLog());
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            UserRepository::class,
            TmpUserRepository::class,
            UserTypeRepository::class,
            ProfileRepository::class,
            AuditLogRepository::class,
        ];
    }
}
