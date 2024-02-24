<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(10),
            'details' => $this->faker->paragraph(),
            'is_active' => $this->faker->randomElement(['0','1']),
            'created_at' => now(),
            'user_id' => User::all()->random()->id,

        ];
    }
}
