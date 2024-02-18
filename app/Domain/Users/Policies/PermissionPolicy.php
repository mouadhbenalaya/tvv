<?php

namespace App\Domain\Users\Policies;

use App\Domain\Users\Enums\Permission;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Profile $profile): bool
    {
        return $profile->can(Permission::VIEW_ALL_PERMISSIONS->value);
    }
}
