<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phone>
 */
class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_code' => fake()->countryCode(),
            'phone' => fake()->phoneNumber(),
            'extension' => fake()->numberBetween(100, 1100),
            'holder_name' => fake()->word(),
            'type' => 'mobile',
        ];
    }
}
