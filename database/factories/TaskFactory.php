<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'created_at' => now(),
            'category_id' => Category::factory(),
            'deadline' => $this->faker->dateTime(),
            'priority_level' => $this->faker->numberBetween(1, 3),
            'position' => $this->faker->numberBetween(1, 5),
            'is_done' => false,
        ];
    }
}
