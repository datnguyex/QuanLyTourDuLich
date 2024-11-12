<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;


class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::create([
            'tour_id' => 1,
            'customer_id' => 1,
            'booking_date' => '2024-11-01',
            'number_of_people' => 3,
            'number_of_adult' => 2,
            'number_of_childrent' => 1,
            'total_price' => 6500000,
            'tour_guide_id' => 1,
        ]);

        Booking::create([
            'tour_id' => 2,
            'customer_id' => 2,
            'booking_date' => '2024-11-02',
            'number_of_people' => 2,
            'number_of_adult' => 2,
            'number_of_childrent' => 0,
            'total_price' => 10000000,
            'tour_guide_id' => 2,
        ]);
    }
}
