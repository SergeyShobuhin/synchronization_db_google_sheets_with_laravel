<?php

namespace Database\Factories;

use App\Enums\DataItemStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataItem>
 */
class DataItemFactory extends Factory
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
            'status' => fake()->randomElement([DataItemStatus::Allowed, DataItemStatus::Prohibited]),
//            'comment' => fake()->text(100),
        ];
    }
}
