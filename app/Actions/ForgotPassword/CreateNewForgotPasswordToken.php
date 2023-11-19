<?php

namespace App\Actions\ForgotPassword;

use App\Notifications\ForgotPasswordNotification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CreateNewForgotPasswordToken
{
    /**
     * @param Authenticatable|Model $model
     * @return bool
     */
    public function handle(Authenticatable|Model $model): bool
    {
        $token = random_int(100000, 999999);

        DB::table('password_reset_tokens')->insert([
            'email' => $model->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $model->notify(new ForgotPasswordNotification($token));

        return true;
    }
}
