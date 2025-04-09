<?php

namespace Database\Factories;

use App\Models\StatusType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status_type_id' => StatusType::factory(),
            'active_date_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
