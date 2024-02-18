<?php

namespace App\Domain\Users\Listeners\Observers;

use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function creating(Model $model): void
    {
        $model->setAttribute('id', $model->getAttribute('id'));
    }

    public function updated(User $user): void
    {
        Cache::forget((string)$user->id);

        if ($user->is_active) {
            Cache::put((string)$user->id, $user, 60);
        }

        Cache::tags('users:' . $user->id)->flush();
    }
}
