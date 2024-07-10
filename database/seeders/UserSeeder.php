<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)
            ->recycle(Country::all())
            ->sequence(
                ['is_blocked' => true],
                ['is_blocked' => false],
            )->create();
    }
}
