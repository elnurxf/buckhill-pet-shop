<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
                'author' => $this->faker->name(),
                'image'  => $image->uuid,
            ],
        ];
    }
}
