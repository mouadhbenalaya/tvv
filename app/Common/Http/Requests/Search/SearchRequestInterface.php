<?php

declare(strict_types=1);

namespace App\Common\Http\Requests\Search;

interface SearchRequestInterface
{
    public function getPaginate(): bool;

    public function getLimit(): int;

    public function getPage(): int;

    public function getOrderBy(): string;

    public function getDirection(): string;

    public function getQuery(): ?string;
}
