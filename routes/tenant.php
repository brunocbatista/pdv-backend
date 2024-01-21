<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RefreshTokenController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPassword\ResetPasswordController;
use App\Http\Controllers\ResetPassword\ResetPasswordTokenValidationController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::group(['prefix' => config('sanctum.prefix', 'sanctum')], static function () {
        Route::get('/csrf-cookie', [CsrfCookieController::class, 'show'])->name('sanctum.csrf-cookie');
    });
});

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])
    ->prefix('api')
    ->name('tenant.api.')
    ->group(function () {
        Route::post('/login', [LoginController::class, 'store'])->name('login');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('forgot-password');
        Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('reset-password');
        Route::post('/reset-password/token/validate', [ResetPasswordTokenValidationController::class, 'store'])->name('reset-password.token.validate');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/refresh-token', [RefreshTokenController::class, 'store'])->name('refresh-token');
            Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

            Route::controller(ProfileController::class)
                ->prefix('/profile')
                ->as('profile.')
                ->group(function () {
                    Route::get('/', 'show')->name('show');
                    Route::put('/', 'update')->name('update');
                    Route::delete('/', 'delete')->name('delete');
                });

            Route::controller(ProductCategoryController::class)
                ->prefix('/product-categories')
                ->as('product-categories.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{id}', 'show')->name('show');
                    Route::put('/{id}', 'update')->name('update');
                    Route::delete('/{id}', 'delete')->name('delete');
                    Route::patch('/{id}/restore', 'restore')->name('restore');
                });

            Route::controller(ProductController::class)
                ->prefix('/products')
                ->as('products.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{id}', 'show')->name('show');
                    Route::put('/{id}', 'update')->name('update');
                    Route::delete('/{id}', 'delete')->name('delete');
                    Route::patch('/{id}/restore', 'restore')->name('restore');
                });
        });
    });
