<?php

namespace App\Domain\Users\Policies;

use App\Domain\Users\Enums\Permission;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::VIEW_ALL_DEPARTMENTS->value);
    }

    public function view(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::VIEW_DEPARTMENT->value);
    }

    public function create(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::CREATE_DEPARTMENT->value);
    }

    public function update(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::UPDATE_DEPARTMENT->value);
    }

    public function delete(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::DELETE_DEPARTMENT->value);
    }

    //    public function restore(User $user, Profile $profile): bool
    //    {
    //        return $profile->can(Permission::RESTORE_DEPARTMENT->value);
    //    }

    public function assign(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::ASSIGN_PROFILE->value);
    }

    public function remove(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::REMOVE_PROFILE->value);
    }

    public function assignRole(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::ASSIGN_ROLE->value);
    }

    public function revokeRole(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::REVOKE_ROLE->value);
    }
}
