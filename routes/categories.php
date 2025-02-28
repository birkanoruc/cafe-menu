<?php

use App\Http\Controllers\Api\V1\CategoryController;
use Illuminate\Support\Facades\Route;

// Category Api Routes
Route::apiResource('categories', CategoryController::class);
