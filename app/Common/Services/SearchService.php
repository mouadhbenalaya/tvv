<?php

declare(strict_types=1);

namespace App\Common\Services;

use App\Common\Http\Requests\Search\SearchRequestInterface;
use Doctrine\DBAL\Types\Types;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Schema;

class SearchService
{
    public function search(Builder $builder, SearchRequestInterface $request): Collection|LengthAwarePaginator
    {
        if (null !== $request->getQuery()) {
            $stringColumns = $this->getTableStringColumns($builder->getModel()->getTable());
            foreach ($stringColumns as $column) {
                $builder->orWhere($column, 'LIKE', '%' . $request->getQuery() . '%');
            }
        }

        $builder->orderBy($request->getOrderBy(), $request->getDirection());

        return match ($request->getPaginate()) {
            true => $builder->paginate($request->getLimit(), ['*'], 'page', $request->getPage()),
            default => $builder->get()
        };
    }

    private function getTableStringColumns(string $table): array
    {
        $stringColumns = [];
        foreach (Schema::getColumnListing($table) as $column) {
            if (in_array(Schema::getColumnType($table, $column), [Types::STRING, Types::TEXT], true)) {
                $stringColumns[] = $column;
            }
        }

        return $stringColumns;
    }
}
