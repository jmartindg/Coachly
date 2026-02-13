<?php

namespace Database\Factories;

use App\Enums\ClientStatus;
use App\Enums\Role;
use App\Enums\Sex;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => Role::Client,
            'client_status' => ClientStatus::Lead,
            'age' => fake()->numberBetween(18, 80),
            'sex' => fake()->randomElement(Sex::cases()),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is a coach.
     */
    public function coach(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::Coach,
        ]);
    }

    /**
     * Indicate that the client has applied and is awaiting coach approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'client_status' => ClientStatus::Pending,
        ]);
    }

    /**
     * Indicate that the client has been approved/onboarded.
     */
    public function applied(): static
    {
        return $this->state(fn (array $attributes) => [
            'client_status' => ClientStatus::Applied,
        ]);
    }
}
