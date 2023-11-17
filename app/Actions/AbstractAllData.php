<?php

namespace App\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class AbstractAllData
{
    /**
     * @return string
     */
    protected abstract function modelName(): string;

    /**
     * @param array $attributes
     * @param array $relations
     * @param array $filters
     * @param array $hidden
     * @param array $appends
     * @param string $orderBy
     * @param string $orderDirection
     * @param bool $withoutPagination
     * @return Collection|LengthAwarePaginator
     */
    public function handle(array $attributes = [], array $relations = [], array $filters = [], array $hidden = [], array $appends = [], string $orderBy = 'created_at', string $orderDirection = 'asc', bool $withoutPagination = false): Collection|LengthAwarePaginator
    {
        $data = $this->modelName()::query()
            ->when($attributes ?? null, function ($query) use ($attributes) {
                $query->select($attributes);
            })
            ->with($relations)
            ->filter($filters)
            ->orderBy($orderBy, $orderDirection);

        if (!$withoutPagination) {
            return $data
                ->paginate(10)
                ->withQueryString()
                ->through(fn($object) => $object->makeHidden($hidden)->append($appends));
        }

        return $data->get()->each(fn($object) => $object->makeHidden($hidden)->append($appends));
    }
}
