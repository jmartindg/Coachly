<?php

namespace Database\Factories;

use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workout_id' => Workout::factory(),
            'name' => fake()->words(2, true),
            'sets' => fake()->optional()->numberBetween(3, 5),
            'reps' => fake()->optional()->randomElement(['8-10', '10-12', '12', 'AMRAP']),
            'sort_order' => 1,
        ];
    }
}
