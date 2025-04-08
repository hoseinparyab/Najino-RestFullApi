<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->state([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('A@d1345678'),
            'first_name' => 'Admin',
            'last_name' => 'AdminUser',
        ])->create();

        User::factory(50)->create();
    }
}
