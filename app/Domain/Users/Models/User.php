<?php

namespace App\Domain\Users\Models;

use App\Domain\Users\Models\UserTvtcOperatorCitie ;
use App\Common\Models\City;
use App\Common\Models\Region;
use App\Common\Traits\Auditable;
use App\Common\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $email_token_confirmation
 * @property bool $is_active
 * @property string $gender
 * @property int $country_id
 * @property int $region_id
 * @property int $city_id
 * @property string $nationality
 * @property string $locale
 * @property int $email_verified_at
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'second_name',
        'third_name',
        'last_name',
        'id_number',
        'email',
        'work_email',
        'department_id',
        'mobile_number',
        'gender',
        'birth_date',
        'password',
        'lives_in_saudi_arabi',
        'country_id',
        'region_id',
        'city_id',
        'nationality_id',
        'email_verified_at',
        'locale',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected string $guard_name = 'api';

    public function getFullNameAttribute(): string // notice that the attribute name is in CamelCase.
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->id;
    }

    public function unreadNotifications(): MorphMany
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->whereNotNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit(15);
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * Get the userTvtcOperatorCities  for the User .
     */
    public function userTvtcOperatorCities(): HasMany
    {
        return $this->hasMany(UserTvtcOperatorCitie::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function currentProfile(): ?Profile
    {
        /** @var ?PersonalAccessToken $token */
        $token = auth()->user()?->currentAccessToken();

        // not authenticated
        if (null === $token) {
            return null;
        }

        /** @var Profile $profile */
        $profile = $this->profiles()
            ->whereHas('userType', function ($query) use ($token) {
                $query->where('name', $token->name);
            })->first();

        return $profile;
    }
}
