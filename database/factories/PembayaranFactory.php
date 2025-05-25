<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Pelatihan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembayaranFactory extends Factory
{
    protected $model = Pembayaran::class;

    public function definition()
    {
        return [
            'idTransaksi' => 'TRX' . $this->faker->unique()->numerify('######'),
            'idGuru' => \App\Models\User::factory(),
            'idPelatihan' => \App\Models\Pelatihan::factory(),
            'total' => $this->faker->randomFloat(2, 100000, 1000000),
            'jumlahDP' => $this->faker->randomFloat(2, 50000, 500000),
            'statusByr' => $this->faker->randomElement(['Pending', 'DP Terbayar', 'Lunas', 'Gagal']),
            'tglBayarDP' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'tglLunas' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}