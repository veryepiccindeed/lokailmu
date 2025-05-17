<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->count(20)->create(); // Create 20 users

        // Optionally, create specific users or users with specific roles
        // User::factory()->create([
        //     'namaLengkap' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     // 'role' => 'admin', // if you add a role attribute
        // ]);
    }
} 