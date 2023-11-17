<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RefreshTokenController;
use App\Http\Controllers\ResetPassword\ResetPasswordController;
use App\Http\Controllers\ResetPassword\ResetPasswordTokenValidationController;
use Illuminate\Support\Facades\Route;

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
});
