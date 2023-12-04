<?php

use App\Enums\UserTypeEnum;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ProductCategory;

test('product categories can be listed', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());

    $response = $this->actingAs($authenticatedUser, 'sanctum')->get(route('tenant.api.product-categories.index'));

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('product categories can be created', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $payload = [
        'name' => 'Test Name',
        'description' => 'Test Description',
    ];

    $response = $this->actingAs($authenticatedUser, 'sanctum')->post(route('tenant.api.product-categories.store'), $payload);

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);

    $this->assertDatabaseHas('product_categories', $payload);
});

test('product categories can be detailed', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $productCategory = ProductCategory::factory()->create();

    $response = $this->actingAs($authenticatedUser, 'sanctum')->get(route('tenant.api.product-categories.show', $productCategory->id));

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('product categories can be updated', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $productCategory = ProductCategory::factory()->create();

    $response = $this->actingAs($authenticatedUser, 'sanctum')->put(route('tenant.api.product-categories.update', $productCategory->id), [
        'name' => 'Test Updated Name',
        'description' => 'Test Updated Description',
    ]);

    expect($productCategory->fresh())
        ->name->toEqual('Test Updated Name')
        ->description->toEqual('Test Updated Description');

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('product categories can be deleted', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $productCategory = ProductCategory::factory()->create();

    $response = $this->actingAs($authenticatedUser, 'sanctum')->delete(route('tenant.api.product-categories.delete', $productCategory->id));

    expect($productCategory->fresh()->deleted_at)
        ->not->toEqual(null);

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('product categories can be restored', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $productCategory = ProductCategory::factory()->create();
    $productCategory->delete();

    $response = $this->actingAs($authenticatedUser, 'sanctum')->patch(route('tenant.api.product-categories.restore', $productCategory->id));

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);

    expect($productCategory->fresh()->deleted_at)
        ->toEqual(null);
});


