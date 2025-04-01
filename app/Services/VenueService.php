<?php

namespace App\Services;

use App\Contracts\Repositories\VenueRepositoryInterface;
use App\Contracts\Services\VenueServiceInterface;
use App\Exceptions\ImageUploadException;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\VenueCollection;
use App\Http\Resources\VenueResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\NotFoundException;
use App\Filters\VenueFilter;
use App\Models\Venue;
use Illuminate\Support\Facades\Auth;

class VenueService implements VenueServiceInterface
{
    // protected VenueRepositoryInterface $venueRepository;

    // public function __construct(VenueRepositoryInterface $venueRepository)
    // {
    //     $this->venueRepository = $venueRepository;
    // }

    public function getAllVenues(array $venueFilters = []): JsonResponse
    {
        // $venues = $this->venueRepository->getAllVenues($venueFilters);

        $venueFilters = new VenueFilter($venueFilters);

        $venues = Venue::query()->where('user_id', Auth::id());

        $filteredVenues = $venueFilters->applyFilters($venues);

        if ($filteredVenues->isEmpty()) {
            throw new NotFoundException("Mekan bulunamadı!", 404);
        }

        return response()->json(new VenueCollection($filteredVenues), 200);
    }

    public function getVenueById(int $venueId): JsonResponse
    {
        // $venue = $this->venueRepository->getVenueById($venueId);

        $venue = Venue::with("categories", "products")->find($venueId);

        if (!$venue) {
            throw new NotFoundException("Mekan bulunamadı!", 404);
        }

        return response()->json(new VenueResource($venue), 200);
    }

    public function createVenue(array $venueData): JsonResponse
    {
        if (isset($venueData['featured_image'])) {
            $venueData['featured_image'] = $this->uploadImage($venueData['featured_image']);
        }

        // $venue = $this->venueRepository->createVenue($venueData);

        $venueData['user_id'] = Auth::id();

        $venue = Venue::create($venueData);

        return response()->json(['message' => 'Mekan başarıyla oluşturuldu!', "venue" => new VenueResource($venue)], 201);
    }

    public function updateVenue(int $venueId, array $venueData): JsonResponse
    {
        // $venue = $this->venueRepository->getVenueById($venueId);

        $venue = Venue::with("categories", "products")->find($venueId);

        if (!$venue) {
            throw new NotFoundException("Mekan bulunamadı!", 404);
        }

        if (isset($venueData['featured_image'])) {

            $venue->featured_image && $this->deleteImage($venue->featured_image);

            $venueData['featured_image'] = $this->uploadImage($venueData['featured_image']);
        }

        // $venue = $this->venueRepository->updateVenue($venue, $venueData);

        $venue->updateOrFail($venueData);

        return response()->json(['message' => 'Mekan başarıyla güncellendi!', "venue" => new VenueResource($venue)], 200);
    }

    public function deleteVenue(int $venueId): JsonResponse
    {
        // $venue = $this->venueRepository->getVenueById($venueId);

        $venue = Venue::with("categories", "products")->find($venueId);

        if (!$venue) {
            throw new NotFoundException("Mekan bulunamadı!", 404);
        }

        $venue->featured_image && $this->deleteImage($venue->featured_image);

        // $this->venueRepository->deleteVenue($venue);

        $venue->deleteOrFail();

        return response()->json(['message' => 'Mekan başarıyla silindi!'], 200);
    }

    public function getCategoriesByVenueId(int $venueId): JsonResponse
    {
        // $venue = $this->venueRepository->getVenueById($venueId);

        $venue = Venue::with("categories", "products")->find($venueId);

        if (!$venue) {
            throw new NotFoundException("Mekan bulunamadı!", 404);
        }

        return response()->json(new CategoryCollection($venue->categories), 200);
    }

    public function getProductsByVenueId(int $venueId): JsonResponse
    {
        // $venue = $this->venueRepository->getVenueById($venueId);

        $venue = Venue::with("categories", "products")->find($venueId);

        if (!$venue) {
            throw new NotFoundException("Mekan bulunamadı!", 404);
        }

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
