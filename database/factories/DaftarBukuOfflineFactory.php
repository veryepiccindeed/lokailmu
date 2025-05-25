<?php

namespace Database\Factories;

use App\Models\DaftarBukuOffline;
use App\Models\DaftarBuku;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DaftarBukuOfflineFactory extends Factory
{
    protected $model = DaftarBukuOffline::class;

    public function definition()
    {
        return [
            'idOffline' => 'OFF' . $this->faker->unique()->numerify('######'),
            'idBuku' => \App\Models\DaftarBuku::factory(),
            'idUser' => \App\Models\User::factory(),
            'pathCache' => 'cache/' . $this->faker->word . '.pdf',
            'tglDownload' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'tglAkses' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}