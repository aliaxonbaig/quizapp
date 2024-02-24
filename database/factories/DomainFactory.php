<?php

namespace Database\Factories;

use App\Models\Certification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain>
 */
class DomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(4),
            'description' => $this->faker->sentence(20),
            'details' => $this->faker->paragraph(),
            'is_active' => $this->faker->randomElement(['0','1']),
            'created_at' => now(),
            'user_id' => User::all()->random()->id,
            'certification_id' => Certification::all()->random()->id,
        ];
    }
}
