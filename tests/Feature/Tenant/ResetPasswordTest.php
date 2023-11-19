<?php

use App\Notifications\ForgotPasswordNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Enums\UserTypeEnum;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

test('users can validate token for reset password', function () {
    Notification::fake();
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);

    $this->post(route('tenant.api.forgot-password'), ['email' => $user->email]);
    Notification::assertSentTo($user, ForgotPasswordNotification::class, function (object $notification) use ($user) {
        $response = $this->post(route('tenant.api.reset-password.token.validate'), [
            'token' => $notification->token,
            'email' => $user->email
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data'
            ]);

        return true;
    });
});

test('users can reset password', function () {
    Notification::fake();
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);


    $this->post(route('tenant.api.forgot-password'), ['email' => $user->email]);
    Notification::assertSentTo($user, ForgotPasswordNotification::class, function (object $notification) use (&$user) {
        $password = 'abc123*';

        $response = $this->post(route('tenant.api.reset-password'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $user = $user->fresh();
        $this->assertTrue(Hash::check($password, $user->password));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data'
            ]);

        return true;
    });
});
