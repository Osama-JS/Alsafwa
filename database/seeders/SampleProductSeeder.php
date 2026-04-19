<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Agency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear existing data to avoid duplication (Optional)
        // Product::truncate();
        // ProductCategory::truncate();

        $data = [
            [
                'name_ar' => 'زيوت المحركات',
                'name_en' => 'Engine Oils',
                'children' => [
                    ['name_ar' => 'زيوت سيارات الركاب', 'name_en' => 'Passenger Car Oils'],
                    ['name_ar' => 'زيوت محركات الديزل الثقيلة', 'name_en' => 'Heavy Duty Diesel Oils'],
                    ['name_ar' => 'زيوت الدراجات النارية', 'name_en' => 'Motorcycle Oils'],
                ]
            ],
            [
                'name_ar' => 'زيوت صناعية',
                'name_en' => 'Industrial Oils',
                'children' => [
                    ['name_ar' => 'زيوت الهيدروليك', 'name_en' => 'Hydraulic Oils'],
                    ['name_ar' => 'زيوت التروس الصناعية', 'name_en' => 'Industrial Gear Oils'],
                    ['name_ar' => 'زيوت الضواغط', 'name_en' => 'Compressor Oils'],
                ]
            ],
            [
                'name_ar' => 'الشحوم',
                'name_en' => 'Greases',
                'children' => [
                    ['name_ar' => 'شحوم الليثيوم', 'name_en' => 'Lithium Greases'],
                    ['name_ar' => 'شحوم الضغط العالي', 'name_en' => 'Extreme Pressure Greases'],
                ]
            ],
            [
                'name_ar' => 'منظفات وكيميائيات',
                'name_en' => 'Cleaners & Chemicals',
                'children' => [] // Main category without children
            ]
        ];

        // Get an agency to link products to
        $agency = Agency::published()->first();
        if (!$agency) {
            $agency = Agency::create([
                'name_ar' => 'وكالة الصفوة الدولية',
                'name_en' => 'Al-Safwa International Agency',
                'slug'    => 'al-safwa-agency',
                'status'  => 'published',
            ]);
        }

        foreach ($data as $catData) {
            $parent = ProductCategory::create([
                'name_ar' => $catData['name_ar'],
                'name_en' => $catData['name_en'],
                'slug'    => Str::slug($catData['name_en']) . '-' . Str::random(3),
                'status'  => 'active',
                'order'   => 0,
            ]);

            if (!empty($catData['children'])) {
                foreach ($catData['children'] as $childData) {
                    $child = ProductCategory::create([
                        'name_ar'   => $childData['name_ar'],
                        'name_en'   => $childData['name_en'],
                        'slug'      => Str::slug($childData['name_en']) . '-' . Str::random(3),
                        'parent_id' => $parent->id,
                        'status'    => 'active',
                        'order'     => 0,
                    ]);

                    // Create some products for each sub-category
                    for ($i = 1; $i <= 3; $i++) {
                        $titleEn = $childData['name_en'] . " Product " . $i;
                        Product::create([
                            'title_ar'            => $childData['name_ar'] . " منتج " . $i,
                            'title_en'            => $titleEn,
                            'description_ar'      => "وصف تجريبي لمنتج " . $childData['name_ar'],
                            'description_en'      => "Sample description for " . $childData['name_en'],
                            'slug'                => Str::slug($titleEn) . "-" . Str::random(5),
                            'product_category_id' => $child->id,
                            'agency_id'           => $agency->id,
                            'price'               => rand(50, 500),
                            'status'              => 'active',
                            'order'               => 0,
                        ]);
                    }
                }
            } else {
                // Create some products for the main category directly
                for ($i = 1; $i <= 3; $i++) {
                    $titleEn = $catData['name_en'] . " Main Product " . $i;
                    Product::create([
                        'title_ar'            => $catData['name_ar'] . " منتج رئيسي " . $i,
                        'title_en'            => $titleEn,
                        'description_ar'      => "وصف تجريبي لمنتج " . $catData['name_ar'],
                        'description_en'      => "Sample description for " . $catData['name_en'],
                        'slug'                => Str::slug($titleEn) . "-" . Str::random(5),
                        'product_category_id' => $parent->id,
                        'agency_id'           => $agency->id,
                        'price'               => rand(100, 1000),
                        'status'              => 'active',
                        'order'               => 0,
                    ]);
                }
            }
        }
    }
}
