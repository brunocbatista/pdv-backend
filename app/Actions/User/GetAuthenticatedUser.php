<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Auth\Authenticatable;

class GetAuthenticatedUser
{
    /**
     * @return Authenticatable
     */
    public function handle(): Authenticatable
    {
        $user = Auth::user();

        if (!$user) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Usuário autenticado não identificado.');
        }

        return $user;
    }
}
