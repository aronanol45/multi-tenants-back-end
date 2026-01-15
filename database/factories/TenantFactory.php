<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = $this->faker->unique()->company();
        $subdomain = str()->slug($company) . '-' . $this->faker->unique()->numberBetween(1, 1000000);

        $logos = [
            \Illuminate\Support\Facades\Storage::url('logos/kXV3v8VDBCmZjaJ3oGadM3kAQyLaNmRJgK1Ya60f.jpg'),
            \Illuminate\Support\Facades\Storage::url('logos/PgUOjskXixIcwOKSqz53HmaUcmaORxVcIIhL6bDJ.jpg'),
            \Illuminate\Support\Facades\Storage::url('logos/xxFlKSiccjCiRepjIEBeHmfosoUjPknxZkgP2ECz.jpg'),
        ];

        return [
            'name' => $company,
            'subdomain' => $subdomain,
            'tenant_logo' => fake()->randomElement($logos),
            'meta_description' => [
                'en' => $this->faker->sentence(),
                'de' => \Faker\Factory::create('de_CH')->sentence(),
                'fr' => \Faker\Factory::create('fr_CH')->sentence(),
            ],
        ];
    }
}
