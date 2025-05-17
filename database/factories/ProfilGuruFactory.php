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
        return [
            'idUser' => User::factory(), // Creates a new User or use User::inRandomOrder()->first()->idUser if users are already seeded
            'NUPTK' => $this->faker->unique()->numerify('################'), // 16 digit NUPTK
            'idSekolah' => Sekolah::factory(), // Creates a new Sekolah or use Sekolah::inRandomOrder()->first()->idSekolah
            'tingkatPengajar' => $this->faker->randomElement(['SD', 'SMP', 'SMA']),
            'pathKTP' => 'ktp_images/' . $this->faker->lexify('????????????') . '.jpg',
        ];
    }
} 