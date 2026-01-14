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
        $company = fake()->unique()->company();
        $subdomain = str()->slug($company) . '-' . fake()->unique()->numberBetween(1, 1000000);

        $baseUrl = config('app.url');
        $logos = [
            $baseUrl . "/storage/logos/kXV3v8VDBCmZjaJ3oGadM3kAQyLaNmRJgK1Ya60f.jpg",
            $baseUrl . "/storage/logos/PgUOjskXixIcwOKSqz53HmaUcmaORxVcIIhL6bDJ.jpg",
            $baseUrl . "/storage/logos/xxFlKSiccjCiRepjIEBeHmfosoUjPknxZkgP2ECz.jpg",
        ];

        return [
            'name' => $company,
            'subdomain' => $subdomain,
            'tenant_logo' => fake()->randomElement($logos),
            'meta_description' => [
                'en' => fake()->sentence(),
                'de' => fake('de_CH')->sentence(),
                'fr' => fake('fr_CH')->sentence(),
            ],
        ];
    }
}
