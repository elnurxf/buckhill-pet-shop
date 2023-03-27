<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Open',
            'Pending payment',
            'Paid',
            'Shipped',
            'Cancelled',
        ];

        foreach ($statuses as $status) {
            OrderStatus::create([
                'title' => $status,
            ]);
        }
    }
}
