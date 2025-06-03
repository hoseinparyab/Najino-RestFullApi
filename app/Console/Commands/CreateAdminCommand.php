<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create {--email= : Optional email of existing user}';

    protected $description = 'Create a new admin user or make an existing user admin';

    public function handle()
    {
        // Check if email option is provided
        $existingEmail = $this->option('email');

        if ($existingEmail) {
            // Try to find the existing user
            $existingUser = User::where('email', $existingEmail)->first();

            if (! $existingUser) {
                $this->error("No user found with email: $existingEmail");
                if (! $this->confirm('Would you like to create a new admin user instead?')) {
                    return 1;
                }
                // Fall through to create a new user
            } else {
                return $this->makeUserAdmin($existingUser);
            }
        }

        $this->info('Creating a new admin user...');

        // Get user information
        $firstName = $this->ask('What is the admin first name?');
        $lastName = $this->ask('What is the admin last name?');
        $email = $this->ask('What is the admin email?');
        $password = $this->secret('What is the admin password?');
        $passwordConfirmation = $this->secret('Please confirm the password');

        // Check if user already exists
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            if ($this->confirm("A user with email $email already exists. Would you like to make this user an admin?")) {
                return $this->makeUserAdmin($existingUser);
            }
            $this->error('Operation cancelled.');

            return 1;
        }

        // Validate input
        $validator = Validator::make([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'first_name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        // Create admin user
        $admin = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return $this->makeUserAdmin($admin);
    }

    /**
     * Make a user an admin
     *
     * @return int
     */
    protected function makeUserAdmin(User $user)
    {
        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();

        if (! $adminRole) {
            $this->error('Admin role not found!');

            return 1;
        }

        // Get all permissions and ensure the admin role has all of them
        $allPermissions = Permission::all();
        $this->ensureAdminHasAllPermissions($adminRole, $allPermissions);

        // Check if user already has admin role
        if ($user->roles()->where('role_id', $adminRole->id)->exists()) {
            $this->line("User '{$user->email}' is already an admin.");

            return 0;
        }

        // Assign admin role
        $user->roles()->attach($adminRole->id);

        $this->info('Admin user created/updated successfully!');
        $this->table(
            ['ID', 'Name', 'Email'],
            [[$user->id, $user->first_name.' '.$user->last_name, $user->email]]
        );

        $this->info("User has been granted {$allPermissions->count()} permissions through the admin role.");

        return 0;
    }

    /**
     * Ensure that the admin role has all available permissions
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $permissions
     * @return void
     */
    protected function ensureAdminHasAllPermissions(Role $adminRole, $permissions)
    {
        // Get IDs of permissions that admin role doesn't have yet
        $existingPermissionIds = $adminRole->permissions()->pluck('id')->toArray();
        $newPermissionIds = $permissions->pluck('id')
            ->filter(function ($id) use ($existingPermissionIds) {
                return ! in_array($id, $existingPermissionIds);
            })
            ->toArray();

        if (count($newPermissionIds) > 0) {
            // Attach new permissions to admin role
            $adminRole->permissions()->attach($newPermissionIds);
            $this->info('Added '.count($newPermissionIds).' new permissions to the admin role.');
        }
    }
}
