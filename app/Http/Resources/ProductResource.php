<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'featured_image_url' => $this->featured_image_url,
            'category_ids' => $this->categories->pluck('id'),
            'categories' => CategoryResource::collection($this->whenLoaded(
                "categories",
                fn() =>
                CategoryResource::collection($this->categories)->each->hideProducts()
            )),
            'links' => [
                "self" => route('products.show', $this->id),
                "update" => route('products.update', $this->id),
                "delete" => route('products.destroy', $this->id),
                "venue" => route('venues.show', $this->venue_id)
            ]
        ];
    }
}
