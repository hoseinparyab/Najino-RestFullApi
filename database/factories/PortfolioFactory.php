<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioFactory extends Factory
{
    protected $model = Portfolio::class;

    public function definition(): array
    {
        return [
            'cover_image' => 'portfolios/cover-' . $this->faker->uuid . '.jpg',
            'images' => [
                'portfolios/image1-' . $this->faker->uuid . '.jpg',
                'portfolios/image2-' . $this->faker->uuid . '.jpg'
            ],
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'site_address' => $this->faker->url,
            'our_job' => $this->faker->jobTitle
        ];
    }
}
