<?php

namespace App\Common\Traits;

use App\Common\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Auditable
{
    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    protected static function bootAuditable(): void
    {
        /** @phpstan-ignore-next-line */
        static::created(static fn (Model $model) => $model->log('create'));
        /** @phpstan-ignore-next-line */
        static::deleted(static fn (Model $model) => $model->log('soft_deleted'));
        /** @phpstan-ignore-next-line */
        static::updated(static fn (Model $model) => $model->log());
    }

    public function log(string $event = 'update'): void
    {
        // add except and hidden values to lists if necessary
        // new changes should be empty on creation, so we're getting attributes on that event
        $except = ['id', 'updated_at', 'created_at'];
        $hidden = ['password'];
        $hiddenFilter = static function ($item, $key) use ($hidden) {
            return in_array($key, $hidden, true) ? '' : $item;
        };

        $new = collect($this->getChanges() ?: $this->getAttributes())->except($except)->map($hiddenFilter);
        $old = ('soft_deleted' === $event) ? collect() :
            collect((array)$this->getRawOriginal())->only($new->keys())->map($hiddenFilter);

        $this->auditLogs()->create([
            'event' => $event,
            'payload' => compact('old', 'new'),
            'created_by' => optional(auth()->user())->id
        ]);
    }
}
