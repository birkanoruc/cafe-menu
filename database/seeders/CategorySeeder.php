<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;
use App\Models\Category;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $venues = Venue::all();

        foreach ($venues as $venue) {
            for ($i = 0; $i < 5; $i++) {
                Category::create([
                    'venue_id' => $venue->id,
                    'name' => $faker->sentence(2),
                    'featured_image' => "/storage/featured_images/categories/category.jpg",
                ]);
            }
        }
    }
}
