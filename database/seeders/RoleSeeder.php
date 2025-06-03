<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role
        $adminRole = Role::createIfNotExists('admin', 'Admin');

        // Create user role
        $userRole = Role::createIfNotExists('user', 'User');

        // Get all permissions and assign to admin role
        $permissions = Permission::all();
        if ($permissions->count() > 0) {
            // Get IDs of all permissions
            $permissionIds = $permissions->pluck('id')->toArray();

            // Sync permissions to admin role (this will add missing ones and keep existing ones)
            $adminRole->permissions()->sync($permissionIds);

            $this->command->info('Added '.count($permissionIds).' permissions to admin role.');
        } else {
            $this->command->warn('No permissions found. Make sure PermissionSeeder runs before RoleSeeder.');
        }
    }
}
