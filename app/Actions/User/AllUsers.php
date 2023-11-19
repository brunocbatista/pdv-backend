<?php

namespace App\Actions\User;

use App\Actions\AbstractAllData;
use App\Models\User;

class AllUsers extends AbstractAllData
{
    /**
     * @return string
     */
    protected function modelName(): string
    {
        return User::class;
    }
}
