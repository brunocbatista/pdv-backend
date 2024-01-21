<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractGetData
{
    /**
     * @return string
     */
    protected abstract function modelName(): string;

    /**
     * @param int $id
     * @param array $attributes
     * @param array $relations
     * @param array $filters
     * @param array $hidden
     * @param array $appends
     * @param bool $withTrashed
     * @return Model
     */
    public function handle(int $id, array $attributes = [], array $relations = [], array $filters = [], array $hidden = [], array $appends = [], bool $withTrashed = false): Model
    {
        $data = $this->modelName()::query()
            ->when($attributes ?? null, function ($query) use ($attributes) {
                $query->select($attributes);
            })
            ->when($withTrashed ?? null, function ($query) use ($attributes) {
                $query->withTrashed();
            })
            ->with($relations)
            ->filter($filters)
            ->where('id', $id)
            ->first();

        if (!$data) {
            abort(Response::HTTP_NOT_FOUND, 'Registro não encontrado. Por favor, tente novamente!');
        }

        return $data->makeHidden($hidden)->append($appends);
    }
}
