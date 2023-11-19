<?php

namespace App\Actions\Authentication;

use Illuminate\Support\Facades\Auth;

class DeleteCurrentAccessToken
{
    /**
     * @return bool
     */
    public function handle()
    {
        return Auth::user()->currentAccessToken()->delete();
    }
}
