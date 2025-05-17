<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilGuru;
use App\Models\User;
use App\Models\Sekolah;

class ProfilGuruSeeder extends Seeder
{
    public function run(): void
    {
        // Attempt to create profiles for a subset of existing users, if available
        // This assumes UserSeeder and SekolahSeeder have run
        $users = User::inRandomOrder()->take(5)->get();
        $sekolahs = Sekolah::inRandomOrder()->get();

        if ($users->isEmpty() || $sekolahs->isEmpty()) {
            // Fallback to creating new users/sekolahs via factory if none exist
            ProfilGuru::factory()->count(5)->create();
            return;
        }

        foreach ($users as $user) {
            // Ensure a user doesn't get multiple guru profiles from this seeder run
            if ($user->profilGuru()->exists()) {
                continue;
            }
            ProfilGuru::factory()->create([
                'idUser' => $user->idUser,
                'idSekolah' => $sekolahs->random()->idSekolah,
            ]);
        }
    }
} 