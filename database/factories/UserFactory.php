<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idUser' => 'U' . Str::random(11),
            'namaLengkap' => $this->faker->name(),
            'tglLahir' => $this->faker->date(),
            'noHP' => $this->faker->unique()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'emailVerifiedAt' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'emailVerifiedAt' => null,
        ]);
    }

    // TODO: Add afterCreating states for ProfilGuru, ProfilMentor, SpesialisasiUser if desired
    // Example for ProfilGuru:
    // public function configure()
    // {
    //     return $this->afterCreating(function (User $user) {
    //         if ($user->role === 'guru') { // Assuming a role attribute exists or can be added
    //             ProfilGuru::factory()->create(['idUser' => $user->idUser]);
    //         }
    //     });
    // }
}
