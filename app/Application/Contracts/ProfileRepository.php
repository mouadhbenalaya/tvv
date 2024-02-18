<?php

namespace App\Application\Contracts;

use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use App\Infrastructure\Contracts\BaseRepository;

interface ProfileRepository extends BaseRepository
{
    public function findDeletedUserProfile(User $user, UserType $userType): ?Profile;
}
