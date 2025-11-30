<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(50000, 500000),
            'size' => 'M,L,XL',
            'stock' => $this->faker->numberBetween(10, 100),
            'description' => $this->faker->sentence(),
            'image' => null,
        ];
    }
}
