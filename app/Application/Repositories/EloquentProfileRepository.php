<?php

namespace App\Application\Repositories;

use App\Application\Contracts\ProfileRepository;
use App\Domain\Users\Enums\UserType as AppUserType;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use App\Infrastructure\Abstracts\EloquentRepository;
use Illuminate\Database\Eloquent\Builder;

class EloquentProfileRepository extends EloquentRepository implements ProfileRepository
{
    public function findDeletedUserProfile(User $user, UserType $userType): ?Profile
    {
        return Profile::where('user_id', $user->id)
            ->where('user_type_id', $userType->id)
            ->withTrashed()
            ->first();
    }

    public static function tvtcProfiles(): Builder
    {
        return Profile::query()
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->where('profiles.user_type_id', '=', UserType::where('name', AppUserType::TVTC_OPERATOR)->first()?->id)
            ->select('profiles.employee_number', 'profiles.user_type_id', 'users.*');
    }

    public static function establishmentProfiles(): Builder
    {
        return Profile::query()
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->where('profiles.user_type_id', '=', UserType::where('name', AppUserType::ESTABLISHMENT_OPERATOR)->first()?->id)
            ->select('profiles.employee_number', 'profiles.user_type_id', 'users.*', 'profiles.id as profile_id');
    }
}
