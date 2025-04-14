<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\EmploymentType;
use App\Models\User;
use App\Models\VisaType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SellingVisa>
 */
class SellingVisaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'nationality_id' => Country::factory(),
            'destination_id' => Country::factory(),
            'visa_type_id' => VisaType::factory(),
            'employment_type_id' => EmploymentType::factory(),
            'provider_name' => $this->faker->company,
            'contact_email' => $this->faker->email,
            'required_qualifications' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
            'is_done' => $this->faker->boolean,
        ];
    }
}
