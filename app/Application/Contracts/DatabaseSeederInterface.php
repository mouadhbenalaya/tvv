<?php

namespace App\Application\Contracts;

interface DatabaseSeederInterface
{
    public function getSeeders(): array;
}
