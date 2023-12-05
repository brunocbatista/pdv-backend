<?php

use App\Enums\UserTypeEnum;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ProductCategory;
use App\Models\Product;

test('products can be listed', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());

    $response = $this->actingAs($authenticatedUser, 'sanctum')->get(route('tenant.api.products.index'));

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('products can be created', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $payload = [
        'name' => 'Test Name',
        'description' => 'Test Description',
        'category_id' => ProductCategory::factory()->create()->id,
        'price' => 100.00
    ];

    $response = $this->actingAs($authenticatedUser, 'sanctum')->post(route('tenant.api.products.store'), $payload);

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);

    $this->assertDatabaseHas('products', $payload);
});

test('products can be detailed', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $product = Product::factory()->create();

    $response = $this->actingAs($authenticatedUser, 'sanctum')->get(route('tenant.api.products.show', $product->id));

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('products can be updated', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $productCategory = ProductCategory::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($authenticatedUser, 'sanctum')->put(route('tenant.api.products.update', $product->id), [
        'name' => 'Test Updated Name',
        'description' => 'Test Updated Description',
        'category_id' => $productCategory->id,
        'price' => 100.00
    ]);

    expect($product->fresh())
        ->name->toEqual('Test Updated Name')
        ->description->toEqual('Test Updated Description')
        ->category_id->toEqual($productCategory->id)
        ->price->toEqual(100.00);

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('products can be deleted', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $product = Product::factory()->create();

    $response = $this->actingAs($authenticatedUser, 'sanctum')->delete(route('tenant.api.products.delete', $product->id));

    expect($product->fresh()->deleted_at)
        ->not->toEqual(null);

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);
});

test('products can be restored', function () {
    $user = User::factory()->create([
        'type_id' => UserTypeEnum::ADMINISTRATOR->value
    ]);
    $authenticatedUser = Sanctum::actingAs($user, UserTypeEnum::ADMINISTRATOR->abilities());
    $product = Product::factory()->create();
    $product->delete();

    $response = $this->actingAs($authenticatedUser, 'sanctum')->patch(route('tenant.api.products.restore', $product->id));

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'message',
            'data'
        ]);

    expect($product->fresh()->deleted_at)
        ->toEqual(null);
});


