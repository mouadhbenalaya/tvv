<?php

namespace App\Infrastructure\Abstracts;

use App\Infrastructure\Contracts\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

abstract class EloquentRepository implements BaseRepository
{
    protected Model $model;

    protected bool $withoutGlobalScopes = false;

    protected array $with = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function with(array $with = []): BaseRepository
    {
        $this->with = $with;
        return $this;
    }

    public function withoutGlobalScopes(): BaseRepository
    {
        $this->withoutGlobalScopes = true;
        return $this;
    }

    public function store(array $data): Model
    {
        return $this->model::create($data);
    }

    public function update(Model $model, array $data): Model
    {
        return tap($model)->update($data);
    }

    public function findByFilters(): LengthAwarePaginator
    {
        return $this->model::with($this->with)->paginate();
    }

    public function findOneById(string $id): ?Model
    {
        if (!empty($this->with) || auth()->check()) {
            return $this->findOneBy(['id' => $id]);
        }

        return Cache::remember($id, now()->addHour(), function () use ($id) {
            return $this->findOneBy(['id' => $id]);
        });
    }

    public function findOneBy(array $criteria): ?Model
    {
        $model =  $this->model::with($this->with);
        if ($this->withoutGlobalScopes) {
            $model->withoutGlobalScopes();
        }

        return $model->where($criteria)->orderByDesc('created_at')->first();
    }
}
