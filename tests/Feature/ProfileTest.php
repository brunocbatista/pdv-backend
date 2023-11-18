<?php

use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Enums\UserTypeEnum;
use Symfony\Component\HttpFoundation\Response;

test('users can show your profile', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());

    $response = $this->actingAs($authenticatedUser, 'sanctum')->get(route('api.profile.show'));

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('users can update your profile', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());

    $response = $this->actingAs($authenticatedUser, 'sanctum')->put(route('api.profile.update'), [
        'name' => 'Test Name',
        'email' => 'test@example.com',
    ]);

    expect($user->fresh())
        ->name->toEqual('Test Name')
        ->email->toEqual('test@example.com');

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('users can delete your profile', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());

    $response = $this->actingAs($authenticatedUser, 'sanctum')->delete(route('api.profile.delete'));

    expect($user->fresh()->deleted_at)
        ->not->toEqual(null);

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});
