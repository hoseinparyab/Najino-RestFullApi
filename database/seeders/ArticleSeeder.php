<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        // Create 50 articles
        Article::factory(50)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            },
            'category_id' => function () use ($categories) {
                return $categories->random()->id;
            }
        ]);
    }
}
