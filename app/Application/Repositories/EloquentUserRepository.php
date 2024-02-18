<?php

namespace App\Application\Repositories;

use App\Application\Contracts\UserRepository;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Infrastructure\Abstracts\EloquentRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EloquentUserRepository extends EloquentRepository implements UserRepository
{
    private string $defaultSort = '-created_at';

    private array $defaultSelect = [
        'id',
        'email',
        'is_active',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    private array $allowedFilters = [
        'is_active',
    ];

    private array $allowedSorts = [
        'updated_at',
        'created_at',
    ];

    private array $allowedIncludes = [
        'profile',
        'notifications',
        'unread_notifications',
    ];

    public function findByFilters(): LengthAwarePaginator
    {
        $perPage = (int)request()->get('limit');
        $perPage = $perPage >= 1 && $perPage <= 100 ? $perPage : 20;

        /** @phpstan-ignore-next-line */
        return User::query()
            ->select($this->defaultSelect)
            ->allowedFilters($this->allowedFilters)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts($this->allowedSorts)
            ->defaultSort($this->defaultSort)
            ->paginate($perPage);
    }

    public function update(Model $model, array $data): Model
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);

            /** @var Authenticatable $user */
            $user = auth()->user();
            event(new PasswordReset($user));
        }

        return parent::update($model, $data);
    }

    public function setNewEmailTokenConfirmation(string $userId): void
    {
        $this->withoutGlobalScopes()
            ->findOneById($userId)
            ?->update([
                'email_token_confirmation' => Str::uuid()->toString(),
            ]);
    }

    public function findUserWithEmailAndType(string $email, int $userTypeId): ?User
    {
        return User::where('email', $email)
            ->whereHas('profiles', function ($profile) use ($userTypeId) {
                $profile->where('user_type_id', $userTypeId);
            })
            ->first();
    }

    public function findExistingUser(string $email): ?User
    {
        return User::where('email', $email)
            ->first();
    }

    public function findExistingUserWithAttribute(string $email, string $attribute, string $value): ?User
    {
        return User::where('email', '!=', $email)
            ->where($attribute, $value)
            ->first();
    }

    public static function investorProfiles(): Builder
    {
        return Profile::query()
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->where('profiles.user_type_id', '=', 1)
            ->select('profiles.employee_number', 'profiles.facility_id', 'profiles.user_type_id', 'users.*');
    }
}
