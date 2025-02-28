<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Venue;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $users = User::all();

        foreach ($users as $user) {

            Venue::create([
                'user_id' => $user->id,
                'name' => $faker->company,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'featured_image' => "/storage/featured_images/venues/venue.jpg",
            ]);
        }
    }
}
