<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRealDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->verified()->create([
            'country_id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
        ]);

        $user->phone()->create([
            'country_code' => '1',
            'phone' => '5555555555',
            'type' => 'mobile',
        ]);

        $role = Role::first();
        $user->attachRole($role);
        $role?->permissions->each(function($permission) use ($role, $user) {
            $user->attachPermission($permission);
        });
    }
}
