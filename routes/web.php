<?php

use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/{venue}/{category}/{product}', [VenueController::class, 'showProduct'])->name('product.show');

Route::get('/{venue}', [VenueController::class, 'show'])->name('venue.show');
Route::get('/', [VenueController::class, 'index'])->name('venues');;

// Vue.js admin paneli için yönlendirme
Route::get('/admin/{any}', function () {
    return view('admin-app');
})->where('any', '.*');
