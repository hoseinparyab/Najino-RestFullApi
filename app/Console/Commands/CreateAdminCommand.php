<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create a new admin user interactively';

    public function handle()
    {
        $this->info('Creating a new admin user...');

        // Get user information
        $firstName = $this->ask('What is the admin first name?');
        $lastName = $this->ask('What is the admin last name?');
        $email = $this->ask('What is the admin email?');
        $password = $this->secret('What is the admin password?');
        $passwordConfirmation = $this->secret('Please confirm the password');

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

        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->error('Admin role not found!');
            return 1;
        }

        // Assign admin role
        $admin->roles()->attach($adminRole->id);

        $this->info('Admin user created successfully!');
        $this->table(
            ['Name', 'Email'],
            [[$admin->first_name . ' ' . $admin->last_name, $admin->email]]
        );

        return 0;
    }
}
