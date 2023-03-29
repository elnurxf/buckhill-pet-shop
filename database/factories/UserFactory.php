<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $avatar = File::inRandomOrder()->first();

        return [
            'first_name'        => $this->faker->firstName(),
            'last_name'         => $this->faker->lastName(),
            'is_admin'          => false,
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make('userpassword'),
            'avatar'            => $avatar->uuid,
            'address'           => $this->faker->address(),
            'phone_number'      => $this->faker->phoneNumber(),
            'is_marketing'      => $this->faker->boolean(),
            'remember_token'    => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
