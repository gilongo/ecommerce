<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usersIds = DB::table('users')->pluck('id');

        return [
            'user_id' => fake()->randomElement($usersIds),
            'total_price' => fake()->numberBetween(100, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
