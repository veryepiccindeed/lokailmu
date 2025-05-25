<?php

namespace Database\Factories;

use App\Models\ThreadForum;
use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadForumFactory extends Factory
{
    protected $model = ThreadForum::class;

    public function definition()
    {
        // Define attributes for ThreadForum.
        // The 'dibuatOleh' will create a User and assign its ID.
        // 'idPostUtama' is explicitly set to null initially.
        // It will be populated by the main ForumPost's ID in the configure() method's afterCreating callback.
        return [
            'idThread' => 'THR' . $this->faker->unique()->numerify('######'),
            'judul' => $this->faker->sentence(3),
            'dibuatOleh' => User::factory(), // Creates a User and its ID will be used.
            'idPostUtama' => null,          // Explicitly set to null.
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (ThreadForum $thread) {
            // After a ThreadForum is created, create its main ForumPost.
            // The 'idUser' for this ForumPost should be the same user who created the thread.
            // $thread->dibuatOleh should hold the ID of the user created by User::factory() in definition().
            $mainPost = ForumPost::factory()->create([
                'idThread' => $thread->idThread,
                'dibuatOleh' => $thread->dibuatOleh, // Corrected: use 'dibuatOleh' which is the FK in forumposts
                // 'parentPost' will default to null from ForumPostFactory, suitable for a main post.
            ]);

            // Update the ThreadForum with the ID of its main post.
            $thread->idPostUtama = $mainPost->idPost;
            $thread->save(); // Persist the change.
        });
    }
}