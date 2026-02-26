<?php

namespace Database\Factories;

use App\Models\Membership;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 10, 50),
            'date' => now(),
            'is_confirmed' => fake()->boolean(80),
            'sender_id' => Membership::factory(),
            'receiver_id' => Membership::factory(),
        ];
    }
}
