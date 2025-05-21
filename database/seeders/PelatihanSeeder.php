<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelatihan;
use App\Helpers\IdGenerator;

class PelatihanSeeder extends Seeder
{
    public function run(): void
    {
        $pelatihans = [
            [
                'judul' => 'Web Development Fundamentals',
                'deskripsi' => 'Pelatihan dasar pengembangan web menggunakan HTML, CSS, dan JavaScript. Cocok untuk pemula yang ingin memulai karir di bidang web development.',
                'biaya' => 1500000,
                'idMentor' => 'USR385321983' // Pastikan ID mentor ini sudah ada di database
            ],
            [
                'judul' => 'Laravel Framework Mastery',
                'deskripsi' => 'Pelatihan lanjutan untuk menguasai framework Laravel. Mencakup konsep MVC, Eloquent ORM, dan best practices dalam pengembangan aplikasi web.',
                'biaya' => 2000000,
                'idMentor' => 'USR385321983'
            ],
            [
                'judul' => 'UI/UX Design Principles',
                'deskripsi' => 'Pelatihan desain antarmuka dan pengalaman pengguna. Mempelajari prinsip-prinsip desain, wireframing, dan prototyping.',
                'biaya' => 1800000,
                'idMentor' => 'USR385321983'
            ],
            [
                'judul' => 'Mobile App Development with Flutter',
                'deskripsi' => 'Pelatihan pengembangan aplikasi mobile menggunakan Flutter. Belajar membuat aplikasi cross-platform yang efisien dan menarik.',
                'biaya' => 2500000,
                'idMentor' => 'USR385321983'
            ],
            [
                'judul' => 'Data Science Fundamentals',
                'deskripsi' => 'Pelatihan dasar data science menggunakan Python. Mencakup analisis data, visualisasi, dan machine learning dasar.',
                'biaya' => 3000000,
                'idMentor' => 'USR385321983'
            ]
        ];

        foreach ($pelatihans as $pelatihan) {
            Pelatihan::create([
                'idPelatihan' => IdGenerator::generatePelatihanId(),
                'judul' => $pelatihan['judul'],
                'deskripsi' => $pelatihan['deskripsi'],
                'biaya' => $pelatihan['biaya'],
                'idMentor' => $pelatihan['idMentor']
            ]);
        }
    }
}