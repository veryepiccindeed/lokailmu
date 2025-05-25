<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelatihan;
use App\Models\User; // Import User model
use App\Helpers\IdGenerator;

class PelatihanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil satu user secara acak untuk dijadikan mentor
        // Pastikan UserSeeder atau UserFactory sudah dijalankan sebelumnya
        $mentor = User::inRandomOrder()->first();

        // Jika tidak ada user sama sekali, buat satu user baru sebagai mentor
        if (!$mentor) {
            $mentor = User::factory()->create();
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

        foreach ($pelatihans as $pelatihanData) {
            Pelatihan::create([
                'idPelatihan' => IdGenerator::generatePelatihanId(),
                'judul' => $pelatihanData['judul'],
                'deskripsi' => $pelatihanData['deskripsi'],
                'biaya' => $pelatihanData['biaya'],
                'idMentor' => $mentor->idUser // Gunakan idUser dari mentor yang diambil/dibuat
            ]);
        }
    }
}