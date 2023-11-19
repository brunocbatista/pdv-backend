<?php

namespace App\Http\Controllers;

use App\Actions\Authentication\CreateNewAccessToken;
use App\Actions\User\GetUser;
use App\Actions\User\GetUserToLogin;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function store(LoginRequest $request, GetUserToLogin $getUserToLogin, CreateNewAccessToken $createNewAccessToken, GetUser $getUser)
    {
        $payload = $request->validated();

        $authenticatedUser = $getUserToLogin->handle($payload['email'], $payload['password']);
        $token = $createNewAccessToken->handle($authenticatedUser, $authenticatedUser->type->abilities);
        $user = $getUser->handle(
            $authenticatedUser->id,
            attributes: ['id', 'name', 'email', 'type_id', 'email_verified_at'],
            relations: ['type:id,description']
        );

        return $this->sendJsonOK(['user' => $user, 'token' => $token]);
    }
}
