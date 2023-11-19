<?php

use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Enums\UserTypeEnum;
use Symfony\Component\HttpFoundation\Response;

test('users can refresh token', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());

    $response = $this->actingAs($authenticatedUser, 'sanctum')->post(route('tenant.api.refresh-token'));

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
