<?php

namespace Database\Factories;

use App\Enum\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        return [
            'product_name' => Str::random(10),
            'amount' => fake()->numberBetween(1, 100),
            'user_id' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(Status::cases())->value,
        ];
    }
}
