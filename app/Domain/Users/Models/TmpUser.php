<?php

namespace App\Domain\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $email
 * @property integer $user_type_id
 * @property string $validation_token
 * @property \DateTime $validated_at
 * @property ?bool $first_validation
 * @property integer $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TmpUser extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'email',
        'user_type_id',
        'validation_token',
        'validated_at',
        'first_validation',
        'user_id',
    ];

    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }
}
