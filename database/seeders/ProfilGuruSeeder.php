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
        // Ambil 3 user acak yang belum punya profil guru
        $users = User::doesntHave('profilGuru')->inRandomOrder()->take(3)->get();
        $sekolahs = Sekolah::inRandomOrder()->get();

        if ($users->isEmpty() || $sekolahs->isEmpty()) {
            // Jika tidak ada user atau sekolah, buat dummy via factory
            ProfilGuru::factory()->count(3)->create([
                'pathKTP' => null,
            ]);
            return;
        }

        foreach ($users as $user) {
            // Ambil sekolah acak untuk relasi NPSN
            $sekolah = $sekolahs->random();
            ProfilGuru::factory()->create([
                'idUser' => $user->idUser,
                'NPSN' => $sekolah->NPSN,
                'pathKTP' => null,
                // Field lain akan diisi oleh factory
            ]);
        }
    }
}