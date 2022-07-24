<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */

     // The Gole Create Random Data 
    public function definition()
    {
        $name = $this->faker->words(3, true);
        return [
            'store_id'     => Store::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'name'          => $name,
            'description'   => $this->faker->words(100, true),
            'slug'          => Str::slug($name),
            'price'         => $this->faker->numberBetween(50, 500),
            'image'         => $this->faker->imageUrl(),
            // The Factory call in DatabaseSeeder.php 
            //Note : No faker in the seeder therefore we use the factories

        ];
    }
}
