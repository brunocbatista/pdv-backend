<?php

namespace App\Http\Controllers;

use App\Actions\User\DeleteAndAnonymizeUser;
use App\Actions\User\GetAuthenticatedUser;
use App\Actions\User\GetUser;
use App\Actions\User\UpdateUser;
use App\Http\Requests\UserUpdateRequest;

class ProfileController extends Controller
{
    public function show(GetAuthenticatedUser $getAuthenticatedUser, GetUser $getUser)
    {
        $authenticatedUser = $getAuthenticatedUser->handle();
        $user = $getUser->handle(
            $authenticatedUser->id,
            attributes: ['id', 'name', 'email', 'type_id', 'email_verified_at'],
            relations: ['type:id,description']
        );

        return $this->sendJsonOK($user->toArray());
    }

    public function update(UserUpdateRequest $request, GetAuthenticatedUser $getAuthenticatedUser, GetUser $getUser, UpdateUser $updateUser)
    {
        $payload = $request->validated();
        $authenticatedUser = $getAuthenticatedUser->handle();
        $updateUser->handle($authenticatedUser, $payload);

        $user = $getUser->handle(
            $authenticatedUser->id,
            attributes: ['id', 'name', 'email', 'type_id', 'email_verified_at'],
            relations: ['type:id,description']
        );

        return $this->sendJsonOK($user->toArray());
    }

    public function delete(GetAuthenticatedUser $getAuthenticatedUser, DeleteAndAnonymizeUser $deleteAndAnonymizeUser)
    {
        $user = $getAuthenticatedUser->handle();
        $deleteAndAnonymizeUser->handle($user);

        return $this->sendJsonOK();
    }
}
