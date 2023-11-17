<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractDeleteData
{
    /**
     * @param Model $model
     * @return bool
     */
    public function handle(Model $model): bool
    {
        return $model->delete();
    }
}
