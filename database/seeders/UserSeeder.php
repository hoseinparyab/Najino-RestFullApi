<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users
        User::factory(50)->create();

        $this->command->info('Created 50 test users');
        $this->command->line('To create admin users, run: php artisan admin:create');
    }
}
