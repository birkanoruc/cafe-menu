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

class VenueController extends Controller
{
    private VenueServiceInterface $venueService;

    public function __construct(VenueServiceInterface $venueService)
    {
        $this->venueService = $venueService;
    }

    public function index(VenueFilterRequest $request): JsonResponse
    {
        return $this->venueService->getAllVenues($request->validated());
    }

    public function show(Venue $venue): JsonResponse
    {
        Gate::authorize('view', $venue);

        return $this->venueService->getVenueById($venue->id);
    }

    public function store(VenueStoreRequest $request): JsonResponse
    {
        return $this->venueService->createVenue($request->validated());
    }

    public function update(VenueUpdateRequest $request, Venue $venue): JsonResponse
    {
        Gate::authorize('update', $venue);

        return $this->venueService->updateVenue($venue->id, $request->validated());
    }

    public function destroy(Venue $venue): JsonResponse
    {
        Gate::authorize('delete', $venue);

        return $this->venueService->deleteVenue($venue->id);
    }

    public function categories(Venue $venue): JsonResponse
    {
        return $this->venueService->getCategoriesByVenueId($venue->id);
    }

    public function products(Venue $venue): JsonResponse
    {
        return $this->venueService->getProductsByVenueId($venue->id);
    }
}
