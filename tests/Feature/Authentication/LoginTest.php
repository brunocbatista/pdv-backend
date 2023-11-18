<?php

use App\Models\User;
use App\Enums\UserTypeEnum;
use Symfony\Component\HttpFoundation\Response;

test('users can authenticate', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);

    $response = $this->post(route('api.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data' => [
                'user',
                'token'
            ]
        ]);
});
