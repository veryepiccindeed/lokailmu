<?php

namespace Database\Factories;

use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

class SekolahFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sekolah::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idSekolah' => $this->faker->unique()->numberBetween(1, 999999),
            'NPSN' => $this->faker->unique()->numerify('########'), // 8 digit NPSN
            'namaSekolah' => $this->faker->company(),
            'alamatSekolah' => $this->faker->address(),
        ];
    }
}
