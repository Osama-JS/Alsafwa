<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Counter;

class CounterSeeder extends Seeder
{
    public function run(): void
    {
        $counters = [
            [
                'title_ar' => 'خدمات احترافية',
                'title_en' => 'Professional Services',
                'value' => 25,
                'icon' => 'fas fa-rocket',
                'order' => 1,
                'status' => 'active'
            ],
            [
                'title_ar' => 'وكالة عالمية',
                'title_en' => 'Global Agencies',
                'value' => 12,
                'icon' => 'fas fa-globe',
                'order' => 2,
                'status' => 'active'
            ],
            [
                'title_ar' => 'فرع معتمد',
                'title_en' => 'Certified Branches',
                'value' => 8,
                'icon' => 'fas fa-building',
                'order' => 3,
                'status' => 'active'
            ],
            [
                'title_ar' => 'نشاط سنوي',
                'title_en' => 'Annual Activities',
                'value' => 150,
                'icon' => 'fas fa-calendar-check',
                'order' => 4,
                'status' => 'active'
            ],
        ];

        foreach ($counters as $counter) {
            Counter::updateOrCreate(
                ['title_en' => $counter['title_en']],
                $counter
            );
        }
    }
}
