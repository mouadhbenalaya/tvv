<?php

namespace App\Domain\Users\Providers;

use App\Domain\Users\Models\Department;
use App\Domain\Users\Models\Permission;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\Role;
use App\Domain\Users\Policies\DepartmentPolicy;
use App\Domain\Users\Policies\PermissionPolicy;
use App\Domain\Users\Policies\ProfilePolicy;
use App\Domain\Users\Policies\RolePolicy;
use App\Infrastructure\Abstracts\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    protected string $alias = 'users';

    protected bool $hasMigrations = true;

    protected bool $hasTranslations = true;

    protected bool $hasPolicies = true;

    protected array $providers = [
        EventServiceProvider::class,
        //        BroadcastServiceProvider::class,
    ];

    protected array $policies = [
        Permission::class       => PermissionPolicy::class,
        Role::class             => RolePolicy::class,
        Profile::class          => ProfilePolicy::class,
        Department::class       => DepartmentPolicy::class,
    ];
}
