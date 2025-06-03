<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This seeder is empty by design
        // Admin users are created only via admin:create command
        $this->command->info('RoleUserSeeder: No users were assigned roles automatically.');
        $this->command->line('Use "php artisan admin:create" to create admin users.');
    }
}
