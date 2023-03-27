<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::random(20) . '.jpg';

        return [
            'name' => $name,
            'path' => 'products/' . $name,
            'size' => $this->faker->randomNumber(4, true),
            'type' => 'image/jpeg',
        ];
    }
}
