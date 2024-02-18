<?php

namespace App\Domain\Users\Listeners\Observers;

use App\Domain\Users\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class RoleObserver
{
    public function creating(Model $model): void
    {
        $model->setAttribute('id', $model->getAttribute('id'));
        /** @phpstan-ignore-next-line */
        $model->guard_name = 'api';
    }

    public function updated(Role $role): void
    {
        $this->created($role);
    }

    public function created(Role $role): void
    {
        Cache::forget('spatie.permission.cache');
    }
}
