<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilMentor;
use App\Models\User;

class ProfilMentorSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil 3 user acak yang belum punya profil mentor maupun profil guru
        $users = User::whereDoesntHave('profilMentor')
            ->whereDoesntHave('profilGuru')
            ->inRandomOrder()
            ->take(3)
            ->get();

        if ($users->isEmpty()) {
            // Jika tidak ada user, buat dummy via factory
            ProfilMentor::factory()->count(3)->create([
                'pathCV' => 'dummy_cv.pdf',
                'pathSertifikat' => 'dummy_sertifikat.pdf',
            ]);
            return;
        }

        foreach ($users as $user) {
            ProfilMentor::factory()->create([
                'idUser' => $user->idUser,
                'pathCV' => 'dummy_cv.pdf',
                'pathSertifikat' => 'dummy_sertifikat.pdf',
                // Field lain akan diisi oleh factory
            ]);
        }
    }
}