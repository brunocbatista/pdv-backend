<?php

namespace App\Http\Controllers;

use App\Actions\ForgotPassword\CreateNewForgotPasswordToken;
use App\Actions\ResetPassword\DeleteAllResetPasswordTokens;
use App\Actions\User\GetUserByEmail;
use App\Http\Requests\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    public function store(ForgotPasswordRequest $request, GetUserByEmail $getUserByEmail, DeleteAllResetPasswordTokens $deleteAllResetPasswordTokens, CreateNewForgotPasswordToken $createNewForgotPasswordToken)
    {
        $payload = $request->validated();

        $user = $getUserByEmail->handle($payload['email']);
        $deleteAllResetPasswordTokens->handle($user->email);
        $createNewForgotPasswordToken->handle($user);

        return $this->sendJsonOK();
    }
}
