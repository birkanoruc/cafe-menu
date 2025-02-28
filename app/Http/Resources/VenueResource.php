<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VenueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'address' => $this->address,
            'phone' => $this->phone,
            'featured_image_url' => $this->featured_image_url,
            'links' => [
                "self" => route('venues.show', $this->id),
                "update" => route('venues.update', $this->id),
                "delete" => route('venues.destroy', $this->id),
                "categories" => route('venues.categories', $this->id),
                "products" => route('venues.products', $this->id)
            ]
        ];
    }
}
