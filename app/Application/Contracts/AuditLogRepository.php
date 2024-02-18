<?php

namespace App\Application\Contracts;

use App\Infrastructure\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

interface AuditLogRepository extends BaseRepository
{
    public function prepareQueryWithFilters(?string $type = null, ?string $id = null, ?string $event = null): Builder;
}
