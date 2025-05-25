<?php

namespace Database\Factories;

use App\Models\SpesialisasiUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpesialisasiUserFactory extends Factory
{
    protected $model = SpesialisasiUser::class;

    public function definition(): array
    {
        return [
            'idUser' => \App\Models\User::factory(),
            'spesialisasi' => $this->faker->jobTitle(),
        ];
    }
}