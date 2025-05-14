<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;

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
