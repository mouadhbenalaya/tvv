<?php

namespace App\Application\Repositories;

use App\Application\Contracts\TmpUserRepository;
use App\Domain\Users\Models\TmpUser;
use App\Infrastructure\Abstracts\EloquentRepository;

class EloquentTmpUserRepository extends EloquentRepository implements TmpUserRepository
{
    public function findValidatedTmpUser(string $validationToken): ?TmpUser
    {
        return TmpUser::where('validation_token', $validationToken)
            ->whereNotNull('validated_at')
            ->first();
    }
}
