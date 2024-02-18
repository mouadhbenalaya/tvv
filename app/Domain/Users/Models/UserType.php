<?php

namespace App\Domain\Users\Models;

use App\Domain\Requests\Models\RequestPermission;
use App\Domain\Users\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserType extends Model
{
    use HasFactory;
    use HasSlug;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_types';



    protected $fillable = [
        'name_en',
        'name_ar',
        'can_register',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function tmpUsers(): HasMany
    {
        return $this->hasMany(TmpUser::class);
    }



    /**
     * Get the RequestPermissions for the userType.
     */
    public function requestPermissions(): HasMany
    {
        return $this->hasMany(RequestPermission::class) ;
    }

}
