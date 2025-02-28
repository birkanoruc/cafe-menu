<?php

use App\Http\Controllers\Api\V1\VenueController;
use Illuminate\Support\Facades\Route;

// Venue Api Routes
Route::apiResource('venues', VenueController::class);
Route::get('venues/{venue}/categories', [VenueController::class, 'categories'])->name('venues.categories');
Route::get('venues/{venue}/products', [VenueController::class, 'products'])->name('venues.products');
