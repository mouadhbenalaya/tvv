<?php

declare(strict_types=1);

namespace App\Common\Http\Requests\Search;

use Illuminate\Http\Request;

use function filter_var;

use const FILTER_VALIDATE_BOOL;

abstract class AbstractSearchRequest implements SearchRequestInterface
{
    public const PAGINATE = true;
    public const LIMIT = 10;
    public const PAGE = 1;
    public const ORDER_BY = 'created_at';
    public const DIRECTION = 'DESC';
    public const QUERY = null;

    private bool $paginate;
    private int $limit;
    private int $page;
    private string $orderBy;
    private string $direction;
    private ?string $query;

    public function __construct(private readonly Request $request)
    {
        $this->paginate = filter_var($this->request->get('paginate', self::PAGINATE), FILTER_VALIDATE_BOOL);
        $this->limit = (int) $this->request->get('limit', self::LIMIT);
        $this->page = (int) $this->request->get('page', self::PAGE);
        $this->orderBy = $this->request->get('orderBy', self::ORDER_BY);
        $this->direction = $this->request->get('direction', self::DIRECTION);
        $this->query = $this->request->get('query', self::QUERY);
    }

    public function getPaginate(): bool
    {
        return $this->paginate;
    }

    public function setPaginate(bool $paginate): void
    {
        $this->paginate = $paginate;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }
}
