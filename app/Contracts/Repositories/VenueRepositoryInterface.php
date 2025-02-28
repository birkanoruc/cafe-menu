<?php

namespace App\Contracts\Repositories;

use App\Models\Venue;
use Illuminate\Pagination\LengthAwarePaginator;

interface VenueRepositoryInterface
{
    /**
     * Tüm mekanları filtreleyerek ilişkileri ile beraber listeleyen depo metodunu tanımlar.
     * @param array $venueFilters
     * @return LengthAwarePaginator
     */
    public function getAllVenues(array $venueFilters = []): LengthAwarePaginator;

    /**
     * Kimliği belirtilen mekanı ilişkileri ile getiren depo metodunu tanımlar.
     * @param int $venueId
     * @return Venue
     */
    public function getVenueById(int $venueId): Venue;

    /**
     * Mekanı oluşturan depo metodunu tanımlar.
     * @param array $venueData
     * @return Venue
     */
    public function createVenue(array $venueData): Venue;

    /**
     * Kimliği belirtilen mekanı güncelleyen depo metodunu tanımlar.
     * @param Venue $venue
     * @param array $venueData
     * @return Venue
     */
    public function updateVenue(Venue $venue, array $venueData): Venue;

    /**
     * Kimliği belirtilen mekanı silen depo metodunu tanımlar.
     * @param Venue $venue
     * @return void
     */
    public function deleteVenue(Venue $venue): void;
}
