<?php

namespace App\Http\Controllers\ResetPassword;

use App\Actions\ResetPassword\ValidateResetPasswordToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateResetPasswordTokenRequest;

class ResetPasswordTokenValidationController extends Controller
{
    public function store(ValidateResetPasswordTokenRequest $request, ValidateResetPasswordToken $validateResetPasswordToken)
    {
        $payload = $request->validated();

        $validateResetPasswordToken->handle($payload['email'], $payload['token']);

        return $this->sendJsonOK();
    }
}
