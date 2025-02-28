<?php

namespace App\Repositories;

use App\Contracts\Repositories\VenueRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Filters\VenueFilter;
use App\Models\Venue;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class VenueRepository implements VenueRepositoryInterface
{
    public function getAllVenues(array $venueFilters = []): LengthAwarePaginator
    {
        $venueFilters = new VenueFilter($venueFilters);

        $venues = Venue::query()->where('user_id', Auth::id());

        $filteredVenues = $venueFilters->applyFilters($venues);

        if ($filteredVenues->isEmpty()) {
            throw new NotFoundException("Mekan bulunamadı!", 404);
        }

        return $filteredVenues;
    }

    public function getVenueById(int $venueId): Venue
    {
        $venue = Venue::with("categories", "products")->find($venueId);

        if (!$venue) {
            throw new NotFoundException("Mekan bulunamadı!", 404);
        }

        return $venue;
    }

    public function createVenue(array $venueData): Venue
    {
        $venueData['user_id'] = Auth::id();

        return Venue::create($venueData);
    }

    public function updateVenue(Venue $venue, array $venueData): Venue
    {
        $venue->updateOrFail($venueData);

        return $venue;
    }

    public function deleteVenue(Venue $venue): void
    {
        $venue->deleteOrFail();
    }
}
