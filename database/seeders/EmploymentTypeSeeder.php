<?php

namespace Database\Seeders;

use App\Models\EmploymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employmentType = EmploymentType::create();
        $employmentType->translations()->createMany([
            [
                'locale' => 'en',
                'name' => 'Full time'
            ],
            [
                'locale' => 'ar',
                'name' => 'دوام كامل'
            ]
        ]);
    }
}
