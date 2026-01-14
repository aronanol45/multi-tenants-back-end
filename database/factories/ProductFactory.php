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
                'en' => $this->faker->words(3, true),
                'de' => \Faker\Factory::create('de_CH')->words(3, true),
                'fr' => \Faker\Factory::create('fr_CH')->words(3, true),
            ],
            'category_name' => [
                'en' => $this->faker->word(),
                'de' => \Faker\Factory::create('de_CH')->word(),
                'fr' => \Faker\Factory::create('fr_CH')->word(),
            ],
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'currency' => 'CHF',
            'description' => [
                'en' => $this->faker->paragraph(),
                'de' => \Faker\Factory::create('de_CH')->paragraph(),
                'fr' => \Faker\Factory::create('fr_CH')->paragraph(),
            ],
            'benefits' => [
                'en' => $this->faker->sentences(3),
                'de' => \Faker\Factory::create('de_CH')->sentences(3),
                'fr' => \Faker\Factory::create('fr_CH')->sentences(3),
            ],
        ];
    }
}
