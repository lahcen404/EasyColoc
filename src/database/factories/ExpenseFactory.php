<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'amount' => fake()->randomFloat(2, 5, 200),
            'date' => fake()->dateTimeThisMonth(),
            'payer_member_id' => Membership::factory(),
            'colocation_id' => Colocation::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
