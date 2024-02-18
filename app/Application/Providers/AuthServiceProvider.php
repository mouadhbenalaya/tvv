<?php

declare(strict_types=1);

namespace App\Application\Providers;

use App\Domain\Users\Models\Department;
use App\Domain\Users\Models\Permission;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\Role;
use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\User;
use App\Domain\Users\Notifications\Registration\TvtcOperatorCreatedSuccessfully;
use App\Domain\Users\Notifications\Registration\UserEmailConfirmation;
use App\Domain\Users\Policies\DepartmentPolicy;
use App\Domain\Users\Policies\PermissionPolicy;
use App\Domain\Users\Policies\ProfilePolicy;
use App\Domain\Users\Policies\RolePolicy;
use App\Domain\Users\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use function config;
use function sprintf;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Profile::class => ProfilePolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Department::class => DepartmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(
            static fn (User $user, string $token) => sprintf(
                '%s/reset-password?email=%s&token=%s',
                config('setup.frontend.url'),
                $user->email,
                $token,
            ),
        );

        UserEmailConfirmation::createUrlUsing(
            static fn (TmpUser $user, string $token) => sprintf(
                '%s/registration/verified?email=%s&token=%s&usertype=%s',
                config('setup.frontend.url'),
                $user->email,
                $token,
                $user->user_type_id
            ),
        );

        TvtcOperatorCreatedSuccessfully::createUrlUsing(
            static fn (User $user, string $token) => sprintf(
                '%s/set-password?email=%s&token=%s',
                config('setup.frontend.url'),
                $user->email,
                $token,
            ),
        );
    }
}
