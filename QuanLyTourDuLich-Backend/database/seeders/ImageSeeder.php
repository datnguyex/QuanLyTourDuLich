<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
<<<<<<< HEAD
use App\Models\Images;
=======
>>>>>>> deaa23191ac8770159aaa71301d3d7c710a70fa6

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
        Images::insert([
            [
                'tour_id' => 1, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 1, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 1, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 1, 
                'image_url' => 'images/img4.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 1, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            //
            [
                'tour_id' => 2, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 2, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 2, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 2, 
                'image_url' => 'images/img4.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 2, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
             //
             [
                'tour_id' => 3, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 3, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 3, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 3, 
                'image_url' => 'images/img4.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 3, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            //
            [
                'tour_id' => 4, 
                'image_url' => 'images/img4.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 4, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 4, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 4, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 4, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            //
            [
                'tour_id' => 5, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 5, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 5, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 5, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 5, 
                'image_url' => 'images/img4.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            //
            [
                'tour_id' => 6, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 6, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 6, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 6, 
                'image_url' => 'images/img4.img',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 6, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            //
            [
                'tour_id' => 7, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 7, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 7, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 7, 
                'image_url' => 'images/img4.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 7, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            //
            [
                'tour_id' => 8, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 8, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 8, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 8, 
                'image_url' => 'images/img4.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 8, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            //
            [
                'tour_id' => 9, 
                'image_url' => 'images/img4.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 9, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 9, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 9, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 9, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            //
            [
                'tour_id' => 10, 
                'image_url' => 'images/img2.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 10, 
                'image_url' => 'images/img1.png',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 10, 
                'image_url' => 'images/img3.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 10, 
                'image_url' => 'images/img5.jpg',
                'alt_text' => 'Image of tour 1',
            ],
            [
                'tour_id' => 10, 
                'image_url' => 'images/img4.jpg',
                'alt_text' => 'Image of tour 1',
            ],
        ]);
    }
    
=======
        //
    }
>>>>>>> deaa23191ac8770159aaa71301d3d7c710a70fa6
}
