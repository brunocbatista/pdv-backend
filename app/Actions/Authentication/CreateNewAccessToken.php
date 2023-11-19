<?php

namespace App\Actions\Authentication;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class CreateNewAccessToken
{
    /**
     * @param Authenticatable|Model $model
     * @param array $abilities
     * @param string $key
     * @return string
     */
    public function handle(Authenticatable|Model $model, array $abilities = [], string $key = 'api'): string
    {
        return $model->createToken($key, $abilities)->plainTextToken;
    }
}
