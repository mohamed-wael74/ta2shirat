<?php

namespace Database\Seeders;

use App\Models\VisaType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $visaType = VisaType::create();
        $visaType->translations()->createMany([
            [
                'locale' => 'en',
                'name' => 'Tourist visa'
            ],
            [
                'locale' => 'ar',
                'name' => 'تأشيرة سياحية'
            ]
        ]);
    }
}
