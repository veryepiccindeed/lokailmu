<?php

namespace Database\Factories;

use App\Models\MediaForum;
use App\Models\ForumPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaForumFactory extends Factory
{
    protected $model = MediaForum::class;

    public function definition()
    {
        return [
            // idmedia integer agar sesuai tipe kolom di database
            'idmedia' => $this->faker->unique()->numberBetween(1, 999999),
            'idPost' => \App\Models\ForumPost::factory(),
            'urlMedia' => 'forum/' . $this->faker->word . '.jpg',
        ];
    }
}