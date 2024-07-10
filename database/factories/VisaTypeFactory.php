<?php

namespace Database\Factories;

use App\Models\VisaType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VisaType>
 */
class VisaTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (VisaType $visaType) {
            $visaType->translations()->createMany([
                [
                    'locale' => 'en',
                    'name' => fake()->word() . ' en'
                ],
                [
                    'locale' => 'ar',
                    'name' => fake()->word() . ' ar',
                ]
            ]);
        });
    }
}
