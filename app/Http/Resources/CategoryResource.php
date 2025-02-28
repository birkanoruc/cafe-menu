<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    protected bool $hideProducts = false;

    public function hideProducts(): void
    {
        $this->hideProducts = true;
    }

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
            'featured_image_url' => $this->featured_image_url,
            $this->hideProducts ? null :
                'products' =>  ProductResource::collection($this->whenLoaded("products")),
            'links' => [
                "self" => route('categories.show', $this->id),
                "update" => route('categories.update', $this->id),
                "delete" => route('categories.destroy', $this->id),
                "venue" => route('venues.show', $this->venue_id)
            ]
        ];
    }
}
