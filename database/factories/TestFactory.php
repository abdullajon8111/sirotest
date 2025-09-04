<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('now', '+1 day');
        $endTime = $this->faker->dateTimeBetween($startTime, '+1 week');
        
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'categories_questions' => [1 => 5], // Default: 5 questions from category 1
            'duration_minutes' => $this->faker->numberBetween(10, 120),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'max_attempts' => $this->faker->numberBetween(1, 5),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
