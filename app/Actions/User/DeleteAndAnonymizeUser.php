<?php

namespace App\Actions\User;

use App\Actions\AbstractDeleteData;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class DeleteAndAnonymizeUser extends AbstractDeleteData
{
    /**
     * @param Authenticatable|Model $model
     * @return bool
     */
    public function handle(Authenticatable|Model $model): bool
    {
        parent::handle($model);
        $model->tokens()->delete();
        $model->name = Crypt::encrypt($model->name);
        $model->email = Crypt::encrypt($model->email);
        $model->save();

        return true;
    }
}
