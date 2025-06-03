<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'slug' => str($title)->slug(),
            'body' => $this->faker->paragraphs(5, true),
            'image' => $this->faker->imageUrl(640, 480, 'article', true),
            'view' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
