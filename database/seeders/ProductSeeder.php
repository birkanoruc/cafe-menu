<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = Category::all();


        foreach ($categories as $category) {
            for ($i = 0; $i < 10; $i++) {

                $price = $faker->randomFloat(2, 1, 100);
                $discountPrice = $faker->optional()->randomFloat(2, 1, $price - 1);

                $product = Product::create([
                    'venue_id' => $category->venue_id,
                    'name' => $faker->sentence(2),
                    'price' => $price,
                    'discount_price' => $discountPrice,
                    'featured_image' => "/storage/featured_images/products/product.jpg",

                    'description' => $faker->sentence,
                ]);

                $product->categories()->attach($category->id);
            }
        }
    }
}
