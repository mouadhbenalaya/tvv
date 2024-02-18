<?php

namespace App\Domain\Users\Policies;

use App\Domain\Users\Enums\Permission;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\Access\Authorizable;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Profile $profile): bool
    {
        if ($user->currentProfile()?->user_type_id === 1 && $profile->user_type_id === 1) {
            return true;
        }

        return $profile->can(Permission::VIEW_ALL_USERS->value);
    }

    public function view(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::VIEW_USER->value) || $profile->id === $user->currentProfile()?->id;
    }

    public function update(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::UPDATE_USER->value) || $profile->id === $user->currentProfile()?->id;
    }

    public function delete(User $user, Profile $profile): bool
    {
        if ($user->currentProfile()?->id === $profile->id) {
            return false;
        }

        return $profile->can(Permission::DELETE_USER->value);
    }

    public function create(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::CREATE_USER->value);
    }
}
