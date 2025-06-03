<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. First create all permissions
            PermissionSeeder::class,

            // 2. Then create roles (admin role will get all permissions automatically)
            RoleSeeder::class,

            // 3. Create users
            UserSeeder::class,

            // 4. Assign roles to users
            RoleUserSeeder::class,

            // 5. Other seeders
            CategorySeeder::class,
            ArticleSeeder::class,
            PortfolioSeeder::class,
        ]);
    }
}
