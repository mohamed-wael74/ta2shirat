<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{

    public function definition()
    {
        return [
            //
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($role) {
            foreach (['en', 'ar'] as $locale) {
                $role->translations()->create([
                    'locale' => $locale,
                    'name' => $this->faker->unique()->word(),
                    'description' => $this->faker->unique()->sentence(),
                ]);
            }
        });
    }
}
