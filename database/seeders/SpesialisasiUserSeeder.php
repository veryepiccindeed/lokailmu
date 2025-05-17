<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpesialisasiUser;
use App\Models\User;

class SpesialisasiUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::inRandomOrder()->take(10)->get(); // Assuming UserSeeder ran

        if ($users->isEmpty()) {
            SpesialisasiUser::factory()->count(10)->create(); // Fallback
            return;
        }

        foreach ($users as $user) {
            // Add 1 to 3 spesialisasi for each selected user
            $count = rand(1,3);
            for($i=0; $i < $count; $i++){
                SpesialisasiUser::factory()->create([
                    'idUser' => $user->idUser,
                ]);
            }
        }
    }
} 