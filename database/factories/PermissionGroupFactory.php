<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PermissionGroup>
 */
class PermissionGroupFactory extends Factory
{
    public function definition()
    {
        return [
            //
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (PermissionGroup $permissionGroup) {
            $permissionGroup->translations()->createMany([
                [
                    'locale' => 'en',
                    'name' => fake()->word() . ' en'
                ],
                [
                    'locale' => 'ar',
                    'name' => fake()->word() . ' ar',
                ]
            ]);
            $permission = Permission::first();
            $permissionGroup->permissions()->sync($permission);
        });
    }
}
