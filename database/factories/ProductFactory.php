<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'in_promo' => false,
            'promo_price' => null,
            'price' => fake()->randomFloat(2, 100, 1000),
            'quantity' => fake()->numberBetween(1, 100),
        ];

    }

    public function inPromo(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'in_promo' => true,
                'promo_price' => fake()->numberBetween(100, $attributes['price'] - 10),
            ];
        });
    }
}
