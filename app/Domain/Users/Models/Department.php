<?php

namespace App\Domain\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Department extends Model
{
    use HasRoles;
    use SoftDeletes;

    protected $fillable = [
        'profile_id',
        'name'
    ];

    protected string $guard_name = 'api';

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
