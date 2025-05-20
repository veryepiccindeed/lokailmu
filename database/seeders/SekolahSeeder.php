<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sekolah;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolahs = [
            [
                'idSekolah' => 1,
                'NPSN' => 12345678,
                'namaSekolah' => 'SMA Negeri 1 Jakarta',
                'alamatSekolah' => 'Jl. Budi Utomo No. 7, Jakarta Pusat'
            ],
            [
                'idSekolah' => 2,
                'NPSN' => 23456789,
                'namaSekolah' => 'SMA Negeri 2 Jakarta',
                'alamatSekolah' => 'Jl. Gajah Mada No. 17, Jakarta Pusat'
            ],
            [
                'idSekolah' => 3,
                'NPSN' => 34567890,
                'namaSekolah' => 'SMP Negeri 1 Jakarta',
                'alamatSekolah' => 'Jl. Salemba Raya No. 18, Jakarta Pusat'
            ],
            [
                'idSekolah' => 4,
                'NPSN' => 45678901,
                'namaSekolah' => 'SMP Negeri 2 Jakarta',
                'alamatSekolah' => 'Jl. Tanah Abang I No. 1, Jakarta Pusat'
            ],
            [
                'idSekolah' => 5,
                'NPSN' => 56789012,
                'namaSekolah' => 'SD Negeri 1 Jakarta',
                'alamatSekolah' => 'Jl. Cikini Raya No. 73, Jakarta Pusat'
            ],
            [
                'idSekolah' => 6,
                'NPSN' => 67890123,
                'namaSekolah' => 'SD Negeri 2 Jakarta',
                'alamatSekolah' => 'Jl. Menteng Raya No. 31, Jakarta Pusat'
            ]
        ];

        foreach ($sekolahs as $sekolah) {
            Sekolah::create($sekolah);
        }
    }
}
