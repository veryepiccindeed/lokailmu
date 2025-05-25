<?php

namespace Database\Factories;

use App\Models\Pelatihan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelatihanFactory extends Factory
{
    protected $model = Pelatihan::class;

    public function definition()
    {
        return [
            'idMentor' => \App\Models\User::factory(),
            'idPelatihan' => 'PEL' . $this->faker->unique()->numerify('######'),
            'judul' => $this->faker->sentence(3),
            'deskripsi' => $this->faker->paragraphs(3, true),
            'biaya' => $this->faker->numberBetween(100000, 1000000),
        ];
    }
}