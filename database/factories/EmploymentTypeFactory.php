<?php

namespace Database\Factories;

use App\Models\EmploymentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmploymentType>
 */
class EmploymentTypeFactory extends Factory
{
    public function definition(): array
    {
        return [

        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (EmploymentType $employmentType) {
            $employmentType->translations()->createMany([
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
