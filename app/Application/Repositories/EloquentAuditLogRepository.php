<?php

namespace App\Application\Repositories;

use App\Application\Contracts\AuditLogRepository;
use App\Infrastructure\Abstracts\EloquentRepository;
use Illuminate\Database\Eloquent\Builder;

class EloquentAuditLogRepository extends EloquentRepository implements AuditLogRepository
{
    public function prepareQueryWithFilters(?string $type = null, ?string $id = null, ?string $event = null): Builder
    {
        $builder = $this->model::query();

        if (null !== $type) {
            $builder->where('auditable_type', $type);
        }

        if (null !== $id) {
            $builder->where('auditable_id', $id);
        }

        if (null !== $event) {
            $builder->where('event', $event);
        }

        return $builder;
    }
}
