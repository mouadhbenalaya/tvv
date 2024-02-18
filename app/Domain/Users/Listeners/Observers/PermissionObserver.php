<?php

namespace App\Domain\Users\Listeners\Observers;

use App\Domain\Users\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PermissionObserver
{
    public function creating(Model $model): void
    {
        $model->setAttribute('id', $model->getAttribute('id'));
        /** @phpstan-ignore-next-line */
        $model->guard_name = 'api';
    }

    public function updated(Permission $permission): void
    {
        $this->created($permission);
    }

    public function created(Permission $permission): void
    {
        Cache::forget('spatie.permission.cache');
    }
}
