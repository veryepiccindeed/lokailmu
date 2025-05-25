<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            // idTag integer agar sesuai tipe kolom di database
            'idTag' => $this->faker->unique()->numberBetween(1, 999999),
            'tag' => $this->faker->unique()->word, // Ensure unique tag names
        ];
    }
}