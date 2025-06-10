<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ThreadForum;
use App\Models\User;
use App\Models\ProfilGuru;

class ThreadForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guruUsers = ProfilGuru::with('user')->get()->pluck('user'); // Get users who are guru

        if ($guruUsers->isEmpty()) {
            $this->command->info('No guru users found. Please seed the users and profil_gurus tables first.');
            return;
        }

        foreach (range(1, 10) as $index) {
            $user = $guruUsers->random();

            ThreadForum::create([
                'idThread' => (string) Str::uuid(),
                'judul' => 'Thread Judul ' . $index,
                'dibuatOleh' => $user->idUser,
                'idPostUtama' => null, // This can be updated later with actual post data
                'kategori' => ['informatika', 'sains', 'bahasa', 'matematika'][array_rand(['informatika', 'sains', 'bahasa', 'matematika'])],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
