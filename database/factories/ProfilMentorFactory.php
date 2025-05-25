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
            'idUser' => \App\Models\User::factory(),
            'pathCV' => 'cvs/' . $this->faker->lexify('????????????') . '.pdf',
            'pathSertifikat' => 'sertifikats/' . $this->faker->lexify('????????????') . '.pdf',
        ];
    }
}