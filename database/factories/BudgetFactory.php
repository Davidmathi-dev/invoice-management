<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-6 months', 'now');
        $end   = fake()->dateTimeBetween($start, '+6 months');

        return [
            'name'        => fake()->randomElement(['Office Expenses', 'Marketing', 'IT & Software', 'Travel', 'Operations', 'HR & Training']),
            'period_type' => fake()->randomElement(['monthly', 'yearly']),
            'amount'      => fake()->randomFloat(2, 10000, 200000),
            'start_date'  => $start->format('Y-m-d'),
            'end_date'    => $end->format('Y-m-d'),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
