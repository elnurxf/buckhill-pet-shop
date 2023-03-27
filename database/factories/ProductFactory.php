<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();
        $brand    = Brand::inRandomOrder()->first();
        $image    = File::inRandomOrder()->first();

        return [
            'category_uuid' => $category->uuid,
            'title'         => substr($this->faker->sentence(5), 0, -1), // remove dot at the end
            'price'         => $this->faker->randomFloat(2, 20, 100),
            'description'   => $this->faker->text,
            'metadata'      => [
                'brand' => $brand->uuid,
                'image' => $image->uuid,
            ],
        ];
    }
}
