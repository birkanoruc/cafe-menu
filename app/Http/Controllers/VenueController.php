<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index(): View
    {
        $venues = Venue::all();
        return view('venues', ['venues' => $venues]);
    }

    public function show($slug): View
    {
        $venue = Venue::where('slug', $slug)->with(["categories.products"])->first();
        return view('menu', ['venue' => $venue]);
    }

    public function showProduct($venueSlug, $categorySlug, $productSlug): View
    {
        $venue = Venue::where('slug', $venueSlug)->firstOrFail();
        $category = $venue->categories()->where('slug', $categorySlug)->firstOrFail();
        $product = $category->products()->where('slug', $productSlug)->firstOrFail();

        return view('product', [
            'venue' => $venue,
            'category' => $category,
            'product' => $product
        ]);
    }
}
