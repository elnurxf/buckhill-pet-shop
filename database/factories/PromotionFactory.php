<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $image = File::inRandomOrder()->first();

        return [
            'title'    => $this->faker->sentence(15),
            'content'  => $this->faker->text(),
            'metadata' => [
                'image'      => $image->uuid,
                'valid_from' => now()->toDateString(),
                'valid_to'   => now()->addMonth()->toDateString(),
            ],
        ];
    }
}
