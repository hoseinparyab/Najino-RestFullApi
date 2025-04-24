<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'comment_create' => 'Create Comments',
            'comment_approve' => 'Approve Comments',
            'comment_delete' => 'Delete Comments',
            'comment_view' => 'View Comments'
        ];

        foreach ($permissions as $name => $display_name) {
            Permission::create([
                'name' => $name,
                'display_name' => $display_name
            ]);
        }

        // Create admin role
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator'
        ]);

        // Assign all permissions to admin role
        $adminRole->permissions()->attach(Permission::all());

        // Create user role
        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'Regular User'
        ]);

        // Assign basic permissions to user role
        $userRole->permissions()->attach(
            Permission::whereIn('name', ['comment_create', 'comment_view'])->get()
        );

        // Assign admin role to the first user (usually the one created during installation)
        if ($user = User::first()) {
            $user->roles()->attach($adminRole);
        }
    }
}
