<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::factory()->state([
            'name' => 'user_read',
            'display_name' => 'User Read',
        ])->create();

        Permission::factory()->state([
            'name' => 'user_create',
            'display_name' => 'User Create',
        ])->create();

        Permission::factory()->state([
            'name' => 'user_update',
            'display_name' => 'User Update',
        ])->create();

        Permission::factory()->state([
            'name' => 'user_delete',
            'display_name' => 'User Delete',
        ])->create();


    }
}
