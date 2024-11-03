<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tours;
use Illuminate\Support\Facades\DB;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $tours = [
            [
                'name' => 'Beach Paradise',
                'description' => 'Enjoy a relaxing day at the beach with sunbathing and water sports.',
                'duration' => '1 Day',
                'price' => 100,
                'start_date' => '2024-06-01',
                'end_date' => '2024-06-01',
                'location' => 'Bahamas',
                'availability' => true,
            ],
            [
                'name' => 'Mountain Adventure',
                'description' => 'A thrilling hike through the mountains with breathtaking views.',
                'duration' => '3 Days',
                'price' => 350,
                'start_date' => '2024-07-10',
                'end_date' => '2024-07-13',
                'location' => 'Rocky Mountains',
                'availability' => true,
            ],
            [
                'name' => 'City Tour',
                'description' => 'Explore the vibrant city life with guided tours of famous landmarks.',
                'duration' => '2 Days',
                'price' => 200,
                'start_date' => '2024-08-15',
                'end_date' => '2024-08-16',
                'location' => 'New York',
                'availability' => false,
            ],
            [
                'name' => 'Desert Safari',
                'description' => 'Experience the thrill of a desert safari with dune bashing and camel rides.',
                'duration' => '1 Day',
                'price' => 150,
                'start_date' => '2024-09-01',
                'end_date' => '2024-09-01',
                'location' => 'Dubai',
                'availability' => true,
            ],
            [
                'name' => 'Historical Tour',
                'description' => 'Visit ancient ruins and learn about historical events.',
                'duration' => '5 Days',
                'price' => 800,
                'start_date' => '2024-10-01',
                'end_date' => '2024-10-05',
                'location' => 'Greece',
                'availability' => true,
            ],
            [
                'name' => 'Wildlife Safari',
                'description' => 'Get up close with wildlife in their natural habitat.',
                'duration' => '4 Days',
                'price' => 600,
                'start_date' => '2024-11-01',
                'end_date' => '2024-11-04',
                'location' => 'Kenya',
                'availability' => true,
            ],
            [
                'name' => 'Culinary Tour',
                'description' => 'Taste the best dishes while exploring local markets and restaurants.',
                'duration' => '3 Days',
                'price' => 250,
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-03',
                'location' => 'Italy',
                'availability' => true,
            ],
            [
                'name' => 'Ski Trip',
                'description' => 'Enjoy skiing in the best ski resorts.',
                'duration' => '1 Week',
                'price' => 1200,
                'start_date' => '2024-12-15',
                'end_date' => '2024-12-22',
                'location' => 'Switzerland',
                'availability' => false,
            ],
            [
                'name' => 'Island Hopping',
                'description' => 'Visit multiple islands and enjoy the beautiful scenery.',
                'duration' => '4 Days',
                'price' => 500,
                'start_date' => '2025-01-05',
                'end_date' => '2025-01-08',
                'location' => 'Thailand',
                'availability' => true,
            ],
            [
                'name' => 'Cruise Experience',
                'description' => 'Relax and enjoy a luxurious cruise with all amenities.',
                'duration' => '1 Week',
                'price' => 1500,
                'start_date' => '2025-02-01',
                'end_date' => '2025-02-08',
                'location' => 'Caribbean',
                'availability' => true,
            ],
        ];

       
        DB::table('tours')->insert($tours);
    }
}
