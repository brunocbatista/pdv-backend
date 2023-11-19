<?php

namespace App\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRestoreData
{
    /**
     * @param Authenticatable|Model $model
     * @return bool
     */
    public function handle(Authenticatable|Model $model): bool
    {
        return $model->restore();
    }
}
