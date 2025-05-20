<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilMentor;
use App\Models\User;

class ProfilMentorSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::inRandomOrder()->take(5)->get(); // Assuming UserSeeder ran

        if ($users->isEmpty()) {
            ProfilMentor::factory()->count(3)->create(); // Fallback
            return;
        }

        foreach ($users as $user) {
            if ($user->profilMentor()->exists() || $user->profilGuru()->exists()) { // Avoid if already mentor or guru
                continue;
            }
            ProfilMentor::factory()->create([
                'idUser' => $user->idUser,
            ]);
        }
    }
} 