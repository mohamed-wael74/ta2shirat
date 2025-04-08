<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusType>
 */
class StatusTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->unique()->word(),
            'color' => $this->faker->hexColor(),
            'is_main' => $this->faker->boolean(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($statusType) {
            foreach (['en', 'ar'] as $locale) {
                $statusType->translations()->create([
                    'locale' => $locale,
                    'name' => $this->faker->unique()->word(),
                ]);
            }
        });
    }
}
