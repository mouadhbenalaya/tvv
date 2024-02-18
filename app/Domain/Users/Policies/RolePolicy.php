<?php

namespace App\Domain\Users\Policies;

use App\Domain\Users\Enums\Permission;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::VIEW_ALL_ROLES->value);
    }

    public function view(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::VIEW_ROLE->value);
    }

    public function create(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::CREATE_ROLE->value);
    }

    public function update(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::UPDATE_ROLE->value);
    }

    public function delete(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::DELETE_ROLE->value);
    }

    //    public function restore(User $user, Profile $profile): bool
    //    {
    //        return $profile->can(Permission::RESTORE_ROLE->value);
    //    }

    public function assign(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::ASSIGN_ROLE->value);
    }

    public function revoke(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::REVOKE_ROLE->value);
    }
}
