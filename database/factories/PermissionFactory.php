<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'display_name' => $this->faker->unique()->word(),
            'description' => $this->faker->unique()->sentence(),
        ];
    }
}
