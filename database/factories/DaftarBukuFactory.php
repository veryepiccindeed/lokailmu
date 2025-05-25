<?php

namespace Database\Factories;

use App\Models\DaftarBuku;
use Illuminate\Database\Eloquent\Factories\Factory;

class DaftarBukuFactory extends Factory
{
    protected $model = DaftarBuku::class;

    public function definition()
    {
        return [
            'idBuku' => 'BUK' . $this->faker->unique()->numerify('######'),
            'judul' => $this->faker->sentence(3),
            'deskripsi' => $this->faker->paragraph,
            'penulis' => $this->faker->name,
            'tglTerbit' => $this->faker->date,
            'urlCover' => 'covers/' . $this->faker->word . '.jpg',
            'genre' => $this->faker->randomElement(['Matematika', 'Bahasa Indonesia', 'IPA', 'Sejarah', 'Geografi', 'IPS']),
        ];
    }
}