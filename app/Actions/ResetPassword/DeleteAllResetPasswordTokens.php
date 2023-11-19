<?php

namespace App\Actions\ResetPassword;

use Illuminate\Support\Facades\DB;

class DeleteAllResetPasswordTokens
{
    /**
     * @param string $email
     * @return bool
     */
    public function handle(string $email): bool
    {
        return DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();
    }
}
