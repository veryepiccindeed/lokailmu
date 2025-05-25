<?php

namespace Database\Factories;

use App\Models\PendaftaranPelatihan;
use App\Models\User;
use App\Models\Pelatihan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendaftaranPelatihanFactory extends Factory
{
    protected $model = PendaftaranPelatihan::class;

    public function definition()
    {
        return [
            'idPelatihan' => \App\Models\Pelatihan::factory(),
            'idUser' => \App\Models\User::factory(),
            'tglMulai' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'tglSelesai' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['pending', 'ongoing', 'done', 'cancelled']),
        ];
    }
}