<?php

namespace App\Actions\User;

use App\Actions\AbstractGetData;
use App\Models\User;

class GetUser extends AbstractGetData
{
    /**
     * @return string
     */
    protected function modelName(): string
    {
        return User::class;
    }
}
