<?php

namespace Database\Factories;

use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certification>
 */
class CertificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'name' => $this->faker->sentence(1),
                'description' => $this->faker->sentence(10),
                'details' => $this->faker->paragraph(),
                'is_active' => $this->faker->randomElement(['0','1']),
                'created_at' => now(),
                'user_id' => User::all()->random()->id,
                'section_id' => Section::all()->random()->id,

        ];
    }
}
