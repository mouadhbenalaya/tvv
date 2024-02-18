<?php

namespace App\Domain\Users\Models;

use App\Domain\Requests\Models\RequestPermissionRole;
use App\Domain\Users\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends \Spatie\Permission\Models\Role
{
    use HasSlug;
    use SoftDeletes;

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'guard_name',
        'department_id',
        'user_type_id',
    ];

    public function rolePermissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }


    /**
    * Get the RequestPermissionRole for the role.
    */
    public function requestPermissionRoles(): HasMany
    {
        return $this->hasMany(RequestPermissionRole::class) ;
    }


}
