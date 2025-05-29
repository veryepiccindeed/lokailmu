<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelatihan;
use App\Models\ProfilMentor; // Import ProfilMentor
use App\Helpers\IdGenerator;

class PelatihanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua mentor yang sudah ada di tabel profilmentors
        $mentors = ProfilMentor::pluck('idUser')->toArray();

        // Jika tidak ada mentor sama sekali, hentikan seeder
        if (empty($mentors)) {
            return;
        }

        $pelatihans = [
            [
                'judul' => 'Web Development Fundamentals',
                'deskripsi' => 'Pelatihan dasar pengembangan web menggunakan HTML, CSS, dan JavaScript. Cocok untuk pemula yang ingin memulai karir di bidang web development.',
                'biaya' => 1500000,
            ],
            [
                'judul' => 'Laravel Framework Mastery',
                'deskripsi' => 'Pelatihan lanjutan untuk menguasai framework Laravel. Mencakup konsep MVC, Eloquent ORM, dan best practices dalam pengembangan aplikasi web.',
                'biaya' => 2000000,
            ],
            [
                'judul' => 'UI/UX Design Principles',
                'deskripsi' => 'Pelatihan desain antarmuka dan pengalaman pengguna. Mempelajari prinsip-prinsip desain, wireframing, dan prototyping.',
                'biaya' => 1800000,
            ],
            [
                'judul' => 'Mobile App Development with Flutter',
                'deskripsi' => 'Pelatihan pengembangan aplikasi mobile menggunakan Flutter. Belajar membuat aplikasi cross-platform yang efisien dan menarik.',
                'biaya' => 2500000,
            ],
            [
                'judul' => 'Data Science Fundamentals',
                'deskripsi' => 'Pelatihan dasar data science menggunakan Python. Mencakup analisis data, visualisasi, dan machine learning dasar.',
                'biaya' => 3000000,
            ]
        ];

        // Assign mentor secara bergantian ke pelatihan
        $mentorCount = count($mentors);
        foreach ($pelatihans as $i => $pelatihanData) {
            Pelatihan::create([
                'idPelatihan' => IdGenerator::generatePelatihanId(),
                'judul' => $pelatihanData['judul'],
                'deskripsi' => $pelatihanData['deskripsi'],
                'biaya' => $pelatihanData['biaya'],
                'idMentor' => $mentors[$i % $mentorCount] // Rotasi mentor
            ]);
        }
    }
}