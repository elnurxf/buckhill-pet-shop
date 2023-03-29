<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $avatar = File::inRandomOrder()->first();

        User::create([
            'first_name'        => 'Buckhill',
            'last_name'         => 'Admin',
            'is_admin'          => true,
            'email'             => 'admin@buckhill.co.uk',
            'email_verified_at' => now(),
            'password'          => Hash::make('admin'),
            'avatar'            => $avatar->uuid,
            'address'           => fake()->address(),
            'phone_number'      => fake()->phoneNumber(),
            'is_marketing'      => fake()->boolean(),
            'remember_token'    => null,
        ]);

        User::factory(20)->create();
    }
}
