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

        $baseUrl = config('app.url');
        $logos = [
            $baseUrl . "/storage/logos/JfRvjsPQWG49xD0rRixjUlEWIjniLzCA4D5VrW3Q.jpg",
            $baseUrl . "/storage/logos/b8dwaXRDGBi3nokfMqEfjcb9HZmBABx656qPyO9H.jpg",
            $baseUrl . "/storage/logos/Of1iMqt5Z7ciERV0rjl5P4GMy1waWoh9u5DlrckJ.png",
            $baseUrl . "/storage/logos/jFUmREMvzXq7W3gquRYUwlngYqiOg94D9cVXAQrD.webp",
        ];

        return [
            'name' => $company,
            'subdomain' => $subdomain,
            'domain' => $subdomain . '.' . config('app.frontend_root_domain', 'glaive.ch'),
            'tenant_logo' => $this->faker->randomElement($logos),
            'meta_description' => [
                'en' => $this->faker->sentence(),
                'de' => \Faker\Factory::create('de_CH')->sentence(),
                'fr' => \Faker\Factory::create('fr_CH')->sentence(),
            ],
        ];
    }
}
