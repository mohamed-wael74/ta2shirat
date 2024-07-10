<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['image', 'file']);
        $fileName = $this->faker->unique()->word() . '.' . $this->getFileType($type);

        return [
            'name' => fake()->word(),
            'type' => $type,
            'path' => 'uploads/' . $fileName,
            'size' => fake()->numberBetween(50, 5000),
            'is_main' => false
        ];
    }

    public function isMain($main = true): static
    {
        return $this->state(fn (array $attributes) => [
            'is_main' => $main,
        ]);
    }

    private function getFileType(string $type): string
    {
        return match ($type) {
            'image' => $this->faker->randomElement(['jpeg', 'png', 'jpg']),
            'file' => $this->faker->randomElement(['pdf', 'csv']),
            default => $this->faker->mimeType(),
        };
    }
}
