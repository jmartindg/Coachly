<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->coach(),
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->sentence(),
            'duration_weeks' => fake()->optional()->numberBetween(4, 16),
        ];
    }
}
