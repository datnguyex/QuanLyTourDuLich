<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ImagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tour_id' => $this->faker->numberBetween(1, 100), // Assuming there are 100 tours
            'image_url' => "1.png", // Generates a random image URL
            'alt_text' => $this->faker->sentence(), // Generates a random sentence for alt text
        ];
    }
}