<?php

namespace App\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractUpdateData
{
    /**
     * @param Authenticatable|Model $model
     * @param array $payload
     * @return bool
     */
    public function handle(Authenticatable|Model $model, array $payload): bool
    {
        $model->fill($payload);
        $model->save();

        return true;
    }
}
