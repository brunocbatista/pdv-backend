<?php

use App\Notifications\ForgotPasswordNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Enums\UserTypeEnum;
use Symfony\Component\HttpFoundation\Response;

test('users can get token for reset password', function () {
    Notification::fake();
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);

    $response = $this->post(route('tenant.api.forgot-password'), ['email' => $user->email]);

    Notification::assertSentTo($user, ForgotPasswordNotification::class, function (object $notification) use ($user) {
        $this->assertDatabaseHas('password_reset_tokens', [
            'token' => $notification->token,
            'email' => $user->email
        ]);

        return true;
    });
    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});
