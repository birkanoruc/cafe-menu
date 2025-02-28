<?php

use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;

// Product Api Routes
Route::apiResource('products', ProductController::class);
