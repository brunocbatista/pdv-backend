<?php

namespace App\Actions\Authentication;

use App\Actions\AbstractCreateNewData;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CreateNewUser extends AbstractCreateNewData
{
    /**
     * @return string
     */
    protected function modelName(): string
    {
        return User::class;
    }

    /**
     * @param array $payload
     * @return Model
     */
    public function handle(array $payload): Model
    {
        $payload['password'] = Hash::make($payload['password']);
        return parent::handle($payload);
    }
}
