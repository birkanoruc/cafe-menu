<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\VenueController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware('jwt.auth')->group(function () {

        require __DIR__ . '/venues.php';

        require __DIR__ . '/categories.php';

        require __DIR__ . '/products.php';
    });

    require __DIR__ . '/auth.php';
});
