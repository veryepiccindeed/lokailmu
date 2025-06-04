<?php

namespace Database\Factories;

use App\Models\ProfilGuru;
use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilGuruFactory extends Factory
{
    protected $model = ProfilGuru::class;

    public function definition(): array
    {
        $sekolah = Sekolah::inRandomOrder()->first(); // Ambil data sekolah secara acak dari tabel hasil seeding

        return [
            'idUser' => \App\Models\User::factory(),
            'NUPTK' => $this->faker->unique()->numerify('################'), // 16 digit NUPTK
            'NPSN' => $sekolah->NPSN, // Ambil NPSN dari data sekolah
            'tingkatPengajar' => $this->faker->randomElement(['SD', 'SMP', 'SMA']),
            'pathKTP' => 'ktp_images/' . $this->faker->lexify('????????????') . '.jpg',
        ];
    }
}