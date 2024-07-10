<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = PermissionGroup::create();
        $group->translations()->createMany([
            [
                'locale' => 'en',
                'name' => 'Main Group'
            ],
            [
                'locale' => 'ar',
                'name' => 'المجموعه الرئيسية'
            ]
        ]);
        $group->permissions()->sync(Permission::all());
    }
}
