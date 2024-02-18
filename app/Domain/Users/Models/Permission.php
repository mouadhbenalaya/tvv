<?php

namespace App\Domain\Users\Models;

use App\Domain\Users\Traits\HasSlug;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasSlug;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'name',
        'name_ar',
        'guard_name',
    ];
}
