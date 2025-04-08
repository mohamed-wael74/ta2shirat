<?php

namespace Database\Seeders;

use App\Models\StatusType;
use Illuminate\Database\Seeder;

class StatusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $statusTypes = [
            [
                'name' => 'Pending',
                'type' => 'pending',
                'color' => '#F28E2D',
                'is_main' => true,
                'ar' => [
                    'name' => 'قيد الإنتظار',
                ],
            ],
            [
                'name' => 'In Review',
                'type' => 'in_review',
                'color' => '#FAC915',
                'is_main' => true,
                'ar' => [
                    'name' => 'قيد المراجعة',
                ],
            ],
            [
                'name' => 'Accepted',
                'type' => 'accepted',
                'color' => '#08C86F',
                'is_main' => true,
                'ar' => [
                    'name' => 'مقبول',
                ],
            ],
            [
                'name' => 'Sold',
                'type' => 'sold',
                'color' => '#C608C8',
                'is_main' => true,
                'ar' => [
                    'name' => 'تم البيع',
                ],
            ],
            [
                'name' => 'Canceled',
                'type' => 'canceled',
                'color' => '#E10000',
                'is_main' => false,
                'ar' => [
                    'name' => 'تم الإلغاء',
                ],
            ],
            [
                'name' => 'Rejected',
                'type' => 'rejected',
                'color' => '#E10000',
                'is_main' => false,
                'ar' => [
                    'name' => 'مرفوض',
                ],
            ],
        ];

        foreach ($statusTypes as $statusTypeData) {
            $category = StatusType::create([
                'type' => $statusTypeData['type'],
                'color' => $statusTypeData['color'],
                'is_main' => $statusTypeData['is_main'],
            ]);

            $category->translations()->create([
                'locale' => 'en',
                'name' => $statusTypeData['name'],
            ]);

            $category->translations()->create([
                'locale' => 'ar',
                'name' => $statusTypeData['ar']['name'],
            ]);
        }
    }
}
