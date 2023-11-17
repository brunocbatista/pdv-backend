<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractCreateNewData
{
    /**
     * @return string
     */
    protected abstract function modelName(): string;

    /**
     * @param array $payload
     * @return Model
     */
    public function handle(array $payload): Model
    {
        return $this->modelName()::create($payload);
    }
}
