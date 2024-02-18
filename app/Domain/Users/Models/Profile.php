<?php

namespace App\Domain\Users\Models;

use App\Common\Traits\Auditable;
use App\Domain\Requests\Models\RequestTransaction;
use App\Domain\Users\Enums\UserType as UserTypeEnum;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Request;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property int $user_id
 * @property int $user_type_id
 */
class Profile extends Model implements \Illuminate\Contracts\Auth\Access\Authorizable
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;
    use HasRoles;
    use Authorizable;
    use Authenticatable;

    protected $fillable = [
        'user_id',
        'user_type_id',
        'employee_number',
        'ad_user_name',
        'department_id',
        'facility_id',
    ];

    protected string $guard_name = 'api';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function isTvtcOperator(): bool
    {
        return UserTypeEnum::TVTC_OPERATOR->value === $this->userType?->name;
    }


    /**
     * Get the list requests for the Profile
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    /**
     * Get the requestTransactions Data for the Profile.
     */
    public function requestTransactions(): HasMany
    {
        return $this->hasMany(RequestTransaction::class);
    }

}
