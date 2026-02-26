<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Enums\ColocationStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Colocation>
 */
class ColocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name' => fake()->streetName() . ' House',
        'status' => ColocationStatus::ACTIVE,
    ];
    }
}
