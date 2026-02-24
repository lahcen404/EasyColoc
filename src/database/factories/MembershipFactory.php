<?php

namespace Database\Factories;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membership>
 */
class MembershipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'user_id' => User::factory(),
        'colocation_id' => Colocation::factory(),
        'reputation_score' => fake()->numberBetween(0, 5),
        'is_owner' => false,
        'joined_at' => now(),
        'left_at' => null,
    ];
    }
}
