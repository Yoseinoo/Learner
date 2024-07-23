<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deck>
 */
class DeckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => fake()->title(),
            'description' => fake()->text(),
            'active' => fake()->boolean(),
            'public' => fake()->boolean(),
            'category_id' => 1,
            'user_id' => null
        ];
    }
}
