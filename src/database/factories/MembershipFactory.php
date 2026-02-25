<?php

namespace Database\Factories;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'colocation_id' => Colocation::factory(),
            'is_owner' => fake()->boolean(20), 
            'joined_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'left_at' => null,
        ];
    }
}
