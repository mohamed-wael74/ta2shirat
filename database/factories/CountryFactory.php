<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => fake()->numerify('00##'),
            'flag' => fake()->countryCode(),
        ];
    }

    public function is_available($available = true): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => $available,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function ($country) {
            foreach (['en', 'ar'] as $locale) {
                $country->translations()->create([
                    'locale' => $locale,
                    'name' => $this->faker->unique()->country()
                ]);
            }
        });
    }
}
