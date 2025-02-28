<?php

namespace App\Contracts\Services;

use Illuminate\Http\JsonResponse;

interface VenueServiceInterface
{
    /**
     * Tüm mekanları filtreleyerek listeleyen metodu tanımlar.
     * @param array $venueFilters
     * @return JsonResponse
     */
    public function getAllVenues(array $venueFilters = []): JsonResponse;

    /**
     * Kimliği belirtilen mekanı getiren metodu tanımlar.
     * @param int $venueId
     * @return JsonResponse
     */
    public function getVenueById(int $venueId): JsonResponse;

    /**
     * Mekan oluşturan metodu tanımlar.
     * @param array $venueData
     * @return JsonResponse
     */
    public function createVenue(array $venueData): JsonResponse;

    /**
     * Mekanı güncelleyen metodu tanımlar.
     * @param int $venueId
     * @param array $venueData
     * @return JsonResponse
     */
    public function updateVenue(int $venueId, array $venueData): JsonResponse;

    /**
     * Kimliği belirtilen mekanı silen metodu tanımlar.
     * @param int $venueId
     * @return JsonResponse
     */
    public function deleteVenue(int $venueId): JsonResponse;

    /**
     * Kimliği belirtilen mekanın kategorilerini getiren metodu tanımlar.
     * @param int $venueId
     * @return JsonResponse
     */
    public function getCategoriesByVenueId(int $venueId): JsonResponse;

    /**
     * Kimliği belirtilen mekanın ürünlerini getiren metodu tanımlar.
     * @param int $venueId
     * @return JsonResponse
     */
    public function getProductsByVenueId(int $venueId): JsonResponse;
}
