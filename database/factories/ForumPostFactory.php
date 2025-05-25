<?php

namespace Database\Factories;

use App\Models\ForumPost;
use App\Models\User;
use App\Models\ThreadForum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumPostFactory extends Factory
{
    protected $model = ForumPost::class;

    public function definition()
    {
        return [
            'idThread' => ThreadForum::factory(), // Default, can be overridden
            'dibuatOleh' => User::factory(),
            'isi' => $this->faker->paragraphs(3, true),
            'parentPost' => null, // Default null untuk post utama
        ];
    }
}