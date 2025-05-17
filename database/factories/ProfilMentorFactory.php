<?php

namespace Database\Factories;

use App\Models\ProfilMentor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilMentorFactory extends Factory
{
    protected $model = ProfilMentor::class;

    public function definition(): array
    {
        return [
            'idUser' => User::factory(), // Or User::inRandomOrder()->first()->idUser
            'pathCV' => 'cvs/' . $this->faker->lexify('????????????') . '.pdf',
            'pathSertifikat' => 'sertifikats/' . $this->faker->lexify('????????????') . '.pdf',
        ];
    }
} 