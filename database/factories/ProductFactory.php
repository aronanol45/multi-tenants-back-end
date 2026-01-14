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
            'name' => [
                'en' => fake()->words(3, true),
                'de' => fake('de_CH')->words(3, true),
                'fr' => fake('fr_CH')->words(3, true),
            ],
            'category_name' => [
                'en' => fake()->word(),
                'de' => fake('de_CH')->word(),
                'fr' => fake('fr_CH')->word(),
            ],
            'price' => fake()->randomFloat(2, 10, 1000),
            'currency' => 'CHF',
            'description' => [
                'en' => fake()->paragraph(),
                'de' => fake('de_CH')->paragraph(),
                'fr' => fake('fr_CH')->paragraph(),
            ],
            'benefits' => [
                'en' => fake()->sentences(3),
                'de' => fake('de_CH')->sentences(3),
                'fr' => fake('fr_CH')->sentences(3),
            ],
        ];
    }
}
