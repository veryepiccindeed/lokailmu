<?php

namespace Database\Factories;

use App\Models\ForumLike;
use App\Models\User;
use App\Models\ForumPost;
use App\Models\ThreadForum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ForumLikeFactory extends Factory
{
    protected $model = ForumLike::class;

    public function definition()
    {
        // Generate a unique thread ID
        $threadId = 'THR' . $this->faker->unique()->numerify('######');
        
        // Create a user for authorship
        $user = User::factory()->create();

        // We need to disable foreign key checks temporarily to break the circular dependency
        DB::statement('PRAGMA foreign_keys=0');
        
        try {
            // 1. First create the thread with idPostUtama as null
            $thread = ThreadForum::create([
                'idThread' => $threadId,
                'judul' => $this->faker->sentence(3),
                'dibuatOleh' => $user->idUser,
                'idPostUtama' => null, // Set to null as the column is nullable
            ]);
            
            // 2. Now create the forum post that references this thread
            $post = ForumPost::create([
                'idThread' => $threadId,
                'dibuatOleh' => $user->idUser,
                'isi' => $this->faker->paragraphs(3, true),
                'tglPost' => now(),
            ]);
            
            // 3. Update the thread with the correct post ID
            $thread->update([
                'idPostUtama' => $post->idPost
            ]);
            
            // 4. Now create the forum like for this post
            return [
                'idLike' => $this->faker->unique()->numberBetween(1, 999999),
                'idPost' => $post->idPost,
                'likeOleh' => User::factory(),
                'tglLike' => $this->faker->dateTimeBetween('-1 year', 'now'),
            ];
        } finally {
            // Re-enable foreign key checks
            DB::statement('PRAGMA foreign_keys=1');
        }
    }
}