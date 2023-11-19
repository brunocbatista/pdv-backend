<?php

namespace App\Http\Controllers\ResetPassword;

use App\Actions\ResetPassword\DeleteAllResetPasswordTokens;
use App\Actions\ResetPassword\ValidateResetPasswordToken;
use App\Actions\User\GetUserByEmail;
use App\Actions\User\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function store(ResetPasswordRequest $request, GetUserByEmail $getUserByEmail, ValidateResetPasswordToken $validateResetPasswordToken, UpdateUser $updateUser, DeleteAllResetPasswordTokens $deleteAllResetPasswordTokens)
    {
        $payload = $request->validated();

        $validateResetPasswordToken->handle($payload['email'], $payload['token']);
        $user = $getUserByEmail->handle($payload['email']);
        $updateUser->handle($user, ['password' => Hash::make($payload['password'])]);
        $deleteAllResetPasswordTokens->handle($user->email);

        return $this->sendJsonOK();
    }
}
