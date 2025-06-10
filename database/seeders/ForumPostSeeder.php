<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\ThreadForum;
use App\Models\ForumPost;
use App\Models\User;

class ForumPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $threads = ThreadForum::all(); // Get all threads
        $users = User::all(); // Get all users

        if ($threads->isEmpty() || $users->isEmpty()) {
            $this->command->info('No threads or users found. Please seed the threadforums and users tables first.');
            return;
        }

        foreach ($threads as $thread) {
            $user = $users->random(); // Random user for the post
            $mainPostTime = Carbon::now()->subMinutes(rand(0, 60));

            // Create the main post for the thread with explicit tglPost
            $mainPost = ForumPost::create([
                'idThread' => $thread->idThread,
                'dibuatOleh' => $user->idUser,
                'isi' => 'Ini adalah isi utama dari thread berjudul "' . $thread->judul . '".',
                'parentPost' => null, // Main post has no parent
                'tglPost' => $mainPostTime,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update the thread to reference the main post
            $thread->idPostUtama = $mainPost->idPost;
            $thread->save();

            // Create additional replies for the thread with explicit tglPost
            foreach (range(1, 3) as $index) {
                $replyUser = $users->random(); // Random user for the reply
                $replyTime = (clone $mainPostTime)->addMinutes(rand(1, 60));
                ForumPost::create([
                    'idThread' => $thread->idThread,
                    'dibuatOleh' => $replyUser->idUser,
                    'isi' => 'Ini adalah balasan ke-' . $index . ' untuk thread "' . $thread->judul . '".',
                    'parentPost' => $mainPost->idPost, // Replies are linked to the main post
                    'tglPost' => $replyTime,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
