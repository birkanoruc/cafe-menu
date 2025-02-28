<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'venues_count' => $this->venues->count(),
            'categories_count' => $this->categories->count(),
            'products_count' => $this->products->count(),
            'links' => [
                "venues" => route('venues.index'),
                "categories" => route('categories.index'),
                "products" => route('products.index'),
            ]
        ];
    }
}
