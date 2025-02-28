<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

// Authorization Api Routes
Route::prefix("auth")->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
    Route::get('verify-email', [AuthController::class, 'verifyEmail'])->name('auth.verify-email');

    Route::middleware('jwt.auth')->group(function () {
        Route::post('send-verify-email', [AuthController::class, 'sendVerifyEmail'])->name('auth.send-verify-email');
        Route::post('logout',  [AuthController::class, 'logout'])->name('auth.logout');
        Route::post('me',  [AuthController::class, 'me'])->name('auth.me');
        Route::post('refresh',  [AuthController::class, 'refresh'])->name('auth.refresh');
        Route::put('update-information', [AuthController::class, 'updateInformation'])->name('auth.update-information');
    });
});
