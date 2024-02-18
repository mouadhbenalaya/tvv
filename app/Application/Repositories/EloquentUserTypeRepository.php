<?php

namespace App\Application\Repositories;

use App\Application\Contracts\UserTypeRepository;
use App\Infrastructure\Abstracts\EloquentRepository;

class EloquentUserTypeRepository extends EloquentRepository implements UserTypeRepository
{
}
