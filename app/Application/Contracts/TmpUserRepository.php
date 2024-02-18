<?php

namespace App\Application\Contracts;

use App\Domain\Users\Models\TmpUser;
use App\Infrastructure\Contracts\BaseRepository;

interface TmpUserRepository extends BaseRepository
{
    public function findValidatedTmpUser(string $validationToken): ?TmpUser;
}
