<?php

namespace App\Actions\ResetPassword;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ValidateResetPasswordToken
{
    public function handle(string $email, string $token): bool
    {
        $tokenData = DB::table('password_reset_tokens')->select( 'token', 'created_at')
            ->where('email', $email)
            ->where('token', $token)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$tokenData || Carbon::parse($tokenData->created_at)->diffInMinutes(Carbon::now()) > config('auth.passwords.users.expire')) {
            abort(Response::HTTP_FORBIDDEN, 'O token informado é inválido.');
        }

        return true;
    }
}
