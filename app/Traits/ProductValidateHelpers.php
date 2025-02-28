<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\Venue;
use Illuminate\Support\Facades\Gate;

trait ProductValidateHelpers
{
    /**
     * Mekanın geçerli olup olmadığını kontrol eder.
     */
    public function validateVenue($validator, int $venueId, int $userId): void
    {
        if (!Venue::where('id', $venueId)->where('user_id', $userId)->exists()) {
            $validator->errors()->add('venue_id', 'Geçersiz mekan kimliği.');
        }
    }

    /**
     * Kategorilerin geçerli olup olmadığını kontrol eder.
     */
    public function validateCategoryIds($validator, array $categoryIds, int $venueId): void
    {
        foreach ($categoryIds as $categoryId) {
            if (!Category::where('id', $categoryId)->where('venue_id', $venueId)->exists()) {
                $validator->errors()->add('category_ids', 'Geçersiz kategori kimliği.');
            }
        }
    }
}
