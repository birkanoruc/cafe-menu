<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Contracts\Services\VenueServiceInterface;
use App\Http\Requests\Venue\VenueFilterRequest;
use App\Http\Requests\Venue\VenueStoreRequest;
use App\Http\Requests\Venue\VenueUpdateRequest;
use App\Models\Venue;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Filters\VenueFilter;
use App\Exceptions\NotFoundException;
use App\Http\Resources\VenueCollection;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\VenueResource;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\ImageUploadException;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;

class VenueController extends Controller
{
    public function index(VenueFilterRequest $request): JsonResponse
    {
        $venueFilters = new VenueFilter($request->validated());

        $venues = Venue::query()->where('user_id', Auth::id());

        $filteredVenues = $venueFilters->applyFilters($venues);

        if ($filteredVenues->isEmpty()) {
            throw new NotFoundException("Mekan bulunamadı!", 404);
        }

        return response()->json(new VenueCollection($filteredVenues), 200);
    }

    public function show(Venue $venue): JsonResponse
    {
        Gate::authorize('view', $venue);

        $venue->load(['categories', 'products']);

        return response()->json(new VenueResource($venue), 200);
    }

    public function store(VenueStoreRequest $request): JsonResponse
    {
        $venueData = $request->validated();

        if ($request->hasFile('featured_image')) {
            $venueData['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        $venueData['user_id'] = Auth::id();

        $venue = Venue::create($venueData);

        return response()->json(['message' => 'Mekan başarıyla oluşturuldu!', "venue" => new VenueResource($venue)], 201);
    }

    public function update(VenueUpdateRequest $request, Venue $venue): JsonResponse
    {
        Gate::authorize('update', $venue);

        $venueData = $request->validated();

        if ($request->hasFile('featured_image')) {

            $venue->featured_image && $this->deleteImage($venue->featured_image);

            $venueData['featured_image'] = $this->uploadImage($venueData['featured_image']);
        }

        $venue->updateOrFail($venueData);

        $venue->load(['categories', 'products']);

        return response()->json(['message' => 'Mekan başarıyla güncellendi!', "venue" => new VenueResource($venue)], 200);
    }

    public function destroy(Venue $venue): JsonResponse
    {
        Gate::authorize('delete', $venue);

        $venue->featured_image && $this->deleteImage($venue->featured_image);

        $venue->deleteOrFail();

        return response()->json(['message' => 'Mekan başarıyla silindi!'], 200);
    }

    public function categories(Venue $venue): JsonResponse
    {
        $venue->load(['categories', 'products']);

        return response()->json(new CategoryCollection($venue->categories), 200);
    }

    public function products(Venue $venue): JsonResponse
    {
        $products = $venue->products()->with('categories')->get();

        return response()->json(new ProductCollection($products), 200);
    }

    protected function uploadImage($image): string
    {
        $path = $image->store('featured_images/venues', 'public');

        if (!$path) {
            throw new ImageUploadException();
        }

        return Storage::url($path);
    }

    protected function deleteImage(string $imagePath): void
    {
        $path = str_replace('/storage/', '', $imagePath);
        Storage::disk('public')->delete($path);
    }
}
