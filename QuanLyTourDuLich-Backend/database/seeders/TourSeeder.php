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
                'description' => 'Enjoy a relaxing day at the beautiful beach with sunbathing, swimming, and exciting water sports. Experience the soothing sound of waves, the warm sun on your skin, and the fresh ocean breeze. Take part in fun activities like beach volleyball and paddleboarding. Relax under a palm tree or enjoy a refreshing drink at a beach bar while watching the sunset. This is a perfect getaway for families, couples, or solo travelers looking to unwind.',
                'duration' => '1 Day',
                'price' => 1000000,
                'start_date' => '2024-06-01',
                'end_date' => '2024-06-01',
                'location' => 'Bahamas',
                'availability' => true,
            ],
            [
                'name' => 'Mountain Adventure',
                'description' => 'A thrilling hike through the majestic mountains with breathtaking views and guided tours. Experience the beauty of nature as you trek through lush forests, encounter unique wildlife, and marvel at stunning vistas. This adventure includes expert guides who share fascinating insights about the local ecology and history. Enjoy cozy campfire evenings, and share stories with fellow adventurers under the starry sky. Perfect for those seeking both adventure and relaxation in a serene mountain setting.',
                'duration' => '3 Days',
                'price' => 2200000,
                'start_date' => '2024-07-10',
                'end_date' => '2024-07-13',
                'location' => 'Rocky Mountains',
                'availability' => true,
            ],
            [
                'name' => 'City Tour',
                'description' => 'Explore the vibrant city life with guided tours of famous landmarks and hidden gems in New York. Stroll through Central Park, visit iconic sites like the Statue of Liberty, and experience the diverse neighborhoods that make the city unique. Our knowledgeable guides provide insights into the citys rich history and culture, along with tips for the best local eateries and shops. Enjoy an unforgettable experience filled with art, food, and lively street performances that capture the essence of New York.',
                'duration' => '2 Days',
                'price' => 3400000,
                'start_date' => '2024-08-15',
                'end_date' => '2024-08-16',
                'location' => 'New York',
                'availability' => false,
            ],
            [
                'name' => 'Desert Safari',
                'description' => 'Experience the thrill of a desert safari with exhilarating dune bashing, camel rides, and cultural insights. Ride over the golden dunes in a 4x4 vehicle, feeling the adrenaline rush as you navigate the sandy landscape. Engage with local Bedouins to learn about their traditions, and enjoy a delightful barbecue dinner under the stars. Participate in activities such as sandboarding and henna painting, making this safari an adventure filled with fun, culture, and stunning desert scenery.',
                'duration' => '1 Day',
                'price' => 900000,
                'start_date' => '2024-09-01',
                'end_date' => '2024-09-01',
                'location' => 'Dubai',
                'availability' => true,
            ],
            [
                'name' => 'Historical Tour',
                'description' => 'Visit ancient ruins and learn about significant historical events that shaped our world over centuries. This immersive experience includes guided visits to UNESCO World Heritage Sites, providing deep insights into ancient civilizations and their contributions. Explore fascinating archaeological sites, breathtaking architecture, and hear captivating stories of triumphs and tragedies. Engage with local historians to understand the cultural significance of each site, making it a perfect journey for history buffs and curious travelers alike.',
                'duration' => '5 Days',
                'price' => 2200000,
                'start_date' => '2024-10-01',
                'end_date' => '2024-10-05',
                'location' => 'Greece',
                'availability' => true,
            ],
            [
                'name' => 'Wildlife Safari',
                'description' => 'Get up close with majestic wildlife in their natural habitat while enjoying the stunning landscapes of Kenya. Experience thrilling game drives where you can spot the Big Five and witness their daily activities. Our expert guides will share their knowledge about conservation efforts and the importance of protecting these incredible creatures. Enjoy evenings around a campfire, exchanging stories with fellow travelers, while listening to the sounds of the African night. This safari promises unforgettable memories and breathtaking views.',
                'duration' => '4 Days',
                'price' => 6000000,
                'start_date' => '2024-11-01',
                'end_date' => '2024-11-04',
                'location' => 'Kenya',
                'availability' => true,
            ],
            [
                'name' => 'Culinary Tour',
                'description' => 'Taste the best traditional dishes while exploring vibrant local markets and renowned restaurants in Italy. Join expert chefs as they guide you through the culinary landscape, teaching you about local ingredients and cooking techniques. Participate in hands-on cooking classes where you can prepare authentic Italian meals. Savor each dish, complemented by exquisite wines, as you immerse yourself in the rich flavors of Italian cuisine. This tour is perfect for food enthusiasts and those looking to experience Italy through its delicious food culture.',
                'duration' => '3 Days',
                'price' => 3300000,
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-03',
                'location' => 'Italy',
                'availability' => true,
            ],
            [
                'name' => 'Ski Trip',
                'description' => 'Enjoy skiing and snowboarding in the best ski resorts while experiencing winter activities and stunning views. This week-long adventure includes access to top-notch slopes suitable for all skill levels. Participate in group lessons with professional instructors, or explore the mountains at your own pace. In the evenings, unwind in cozy lodges with hot drinks, sharing stories of your day’s adventures. Embrace the winter wonderland with activities like snowshoeing and après-ski fun, making it an unforgettable holiday experience.',
                'duration' => '1 Week',
                'price' => 1100000,
                'start_date' => '2024-12-15',
                'end_date' => '2024-12-22',
                'location' => 'Switzerland',
                'availability' => false,
            ],
            [
                'name' => 'Island Hopping',
                'description' => 'Visit multiple stunning islands and enjoy breathtaking scenery, beaches, and local cultures in Thailand. This tour takes you on a journey through crystal-clear waters and vibrant marine life, allowing for activities like snorkeling and swimming. Experience the warmth of Thai hospitality as you explore local markets, sample delicious street food, and participate in traditional ceremonies. With plenty of time for relaxation on pristine beaches, this is an ideal escape for those looking to explore and unwind in paradise.',
                'duration' => '4 Days',
                'price' => 3300000,
                'start_date' => '2025-01-05',
                'end_date' => '2025-01-08',
                'location' => 'Thailand',
                'availability' => true,
            ],
            [
                'name' => 'Cruise Experience',
                'description' => 'Relax and enjoy a luxurious cruise with all amenities, gourmet dining, and exciting activities at sea. Indulge in a variety of culinary delights prepared by world-class chefs, and enjoy entertainment ranging from live shows to themed parties. Participate in onboard activities like yoga classes, cooking demonstrations, or simply unwind by the pool. Each port of call offers unique excursions, allowing you to explore beautiful destinations and immerse yourself in local cultures. This cruise promises a perfect blend of relaxation and adventure.',
                'duration' => '1 Week',
                'price' => 4400000,
                'start_date' => '2025-02-01',
                'end_date' => '2025-02-08',
                'location' => 'Caribbean',
                'availability' => true,
            ],
        ];
        

       
        DB::table('tours')->insert($tours);
    }
}
