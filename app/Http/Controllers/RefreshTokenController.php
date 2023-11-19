<?php

namespace App\Http\Controllers;

use App\Actions\Authentication\CreateNewAccessToken;
use App\Actions\Authentication\DeleteCurrentAccessToken;
use App\Actions\User\GetAuthenticatedUser;
use App\Actions\User\GetUser;

class RefreshTokenController extends Controller
{
    public function store(GetAuthenticatedUser $getAuthenticatedUser, DeleteCurrentAccessToken $deleteCurrentAccessToken, CreateNewAccessToken $createNewAccessToken, GetUser $getUser)
    {
        $authenticatedUser = $getAuthenticatedUser->handle();
        $deleteCurrentAccessToken->handle();
        $token = $createNewAccessToken->handle($authenticatedUser, $authenticatedUser->type->abilities);
        $user = $getUser->handle(
            $authenticatedUser->id,
            attributes: ['id', 'name', 'email', 'type_id', 'email_verified_at'],
            relations: ['type:id,description']
        );

        return $this->sendJsonOK(['user' => $user, 'token' => $token]);
    }
}
