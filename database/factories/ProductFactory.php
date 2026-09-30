<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->words(3, true),
            'type'        => fake()->randomElement(['product', 'service']),
            'description' => fake()->sentence(),
            'price'       => fake()->randomFloat(2, 50, 5000),
            'tax_rate'    => fake()->randomElement([0, 5, 12, 18, 28]),
        ];
    }
}
