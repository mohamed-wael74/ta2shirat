<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            LaratrustSeeder::class,
            PermissionGroupSeeder::class,
            UserRealDataSeeder::class,
            UserSeeder::class,
            VisaTypeSeeder::class,
            EmploymentTypeSeeder::class
        ]);
    }
}
