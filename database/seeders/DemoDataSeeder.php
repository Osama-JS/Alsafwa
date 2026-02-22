<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Agency;
use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\Slider;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\Branch;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::first()->id ?? 1;

        // --- Sliders ---
        Slider::updateOrCreate(['title_ar' => 'نحو آفاق تجارية واسعة'], [
            'title_en' => 'Towards Vast Commercial Horizons',
            'subtitle_ar' => 'شركة الصفوة للتجارة والاستثمار - شريككم الموثوق في النجاح',
            'subtitle_en' => 'Alsafua Trading & Investment - Your Trusted Partner in Success',
            'image' => 'demo/slider1.jpg',
            'link' => '#',
            'button_text_ar' => 'اكتشف المزيد',
            'button_text_en' => 'Explore More',
            'duration' => 5000,
            'status' => 'active',
            'order' => 1
        ]);

        Slider::updateOrCreate(['title_ar' => 'جودة لا تضاهى'], [
            'title_en' => 'Unbeatable Quality',
            'subtitle_ar' => 'نقدم أفضل الخدمات والمنتجات العالمية بأعلى المعايير',
            'subtitle_en' => 'Providing the best global services and products with the highest standards',
            'image' => 'demo/slider2.jpg',
            'link' => '#',
            'button_text_ar' => 'خدماتنا',
            'button_text_en' => 'Our Services',
            'duration' => 5000,
            'status' => 'active',
            'order' => 2
        ]);

        // --- Services ---
        $services = [
            [
                'title_ar' => 'التجارة الدولية',
                'title_en' => 'International Trade',
                'description_ar' => 'حلول متكاملة للاستيراد والتصدير عبر القارات بفعالية وأمان.',
                'description_en' => 'Integrated import and export solutions across continents efficiently and safely.',
                'icon' => 'fas fa-ship',
                'slug' => 'international-trade',
            ],
            [
                'title_ar' => 'الاستثمار الاستراتيجي',
                'title_en' => 'Strategic Investment',
                'description_ar' => 'تنمية رؤوس الأموال عبر مشاريع اقتصادية مدروسة ومضمونة.',
                'description_en' => 'Capital growth through well-studied and guaranteed economic projects.',
                'icon' => 'fas fa-chart-line',
                'slug' => 'strategic-investment',
            ],
            [
                'title_ar' => 'التطوير العقاري',
                'title_en' => 'Real Estate Development',
                'description_ar' => 'بناء وتطوير مجمعات سكنية وتجارية بمعايير عالمية.',
                'description_en' => 'Building and developing residential and commercial complexes with global standards.',
                'icon' => 'fas fa-city',
                'slug' => 'real-estate-dev',
            ],
            [
                'title_ar' => 'الخدمات اللوجستية',
                'title_en' => 'Logistics & Supply',
                'description_ar' => 'إدارة سلاسل التوريد والخدمات اللوجستية بأحدث التقنيات.',
                'description_en' => 'Supply chain management and logistics services with the latest technologies.',
                'icon' => 'fas fa-truck-loading',
                'slug' => 'logistics-supply',
            ],
            [
                'title_ar' => 'استشارات الأعمال',
                'title_en' => 'Business Consultancy',
                'description_ar' => 'تقديم حلول استشارية لتطوير الشركات ورفع كفاءة الأداء.',
                'description_en' => 'Providing consulting solutions for company development and performance improvement.',
                'icon' => 'fas fa-briefcase',
                'slug' => 'consultancy',
            ],
            [
                'title_ar' => 'تكنولوجيا البيانات',
                'title_en' => 'Data Technology',
                'description_ar' => 'تمكين الشركات رقمياً عبر أدوات تحليل البيانات والذكاء الاصطناعي.',
                'description_en' => 'Empowering companies digitally through data analytics and AI tools.',
                'icon' => 'fas fa-microchip',
                'slug' => 'data-tech',
            ],
        ];

        foreach ($services as $i => $s) {
            Service::updateOrCreate(['slug' => $s['slug']], array_merge($s, [
                'content_ar' => '<p>' . $s['description_ar'] . ' نحن رواد في هذا المجال ونقدم حلولاً مبتكرة تلبي تطلعات شركائنا وتساعدهم على تحقيق الريادة في أسواقهم التنافسية.</p>',
                'content_en' => '<p>' . $s['description_en'] . ' We are leaders in this field, providing innovative solutions that meet our partners\' aspirations and help them achieve leadership in their competitive markets.</p>',
                'image' => null, // Let the frontend fallback handle images for demo if not provided
                'status' => 'published',
                'order' => $i + 1,
                'created_by' => $adminId
            ]));
        }

        // --- Agencies ---
        $agencies = [
            ['name_ar' => 'مرسيدس بنز', 'name_en' => 'Mercedes-Benz', 'slug' => 'mercedes'],
            ['name_ar' => 'هواوي العالمية', 'name_en' => 'Huawei Global', 'slug' => 'huawei'],
            ['name_ar' => 'شنايدر إلكتريك', 'name_en' => 'Schneider Electric', 'slug' => 'schneider'],
            ['name_ar' => 'مايكروسوفت', 'name_en' => 'Microsoft', 'slug' => 'microsoft'],
            ['name_ar' => 'سيمنز', 'name_en' => 'Siemens', 'slug' => 'siemens'],
            ['name_ar' => 'أرامكو', 'name_en' => 'Aramco', 'slug' => 'aramco'],
        ];

        foreach ($agencies as $i => $a) {
            Agency::updateOrCreate(['slug' => $a['slug']], array_merge($a, [
                'description_ar' => 'شركة الصفوة هي الوكيل الاستراتيجي المعتمد لمنتجات ' . $a['name_ar'] . ' في الأسواق المحلية والإقليمية.',
                'description_en' => 'Alsafua Group is the strategic authorized agent for ' . $a['name_en'] . ' products in local and regional markets.',
                'logo' => null, // Placeholder will be used or user can upload
                'status' => 'published',
                'order' => $i + 1,
                'created_by' => $adminId
            ]));
        }

        // --- Activity Categories & Activities ---
        $actCat = ActivityCategory::updateOrCreate(['slug' => 'social-responsibility'], [
            'name_ar' => 'المسؤولية الاجتماعية',
            'name_en' => 'Social Responsibility',
            'status' => 'active'
        ]);
        $actCat2 = ActivityCategory::updateOrCreate(['slug' => 'corporate-news'], [
            'name_ar' => 'أخبار المجموعة',
            'name_en' => 'Group News',
            'status' => 'active'
        ]);

        Activity::updateOrCreate(['slug' => 'global-forum-2024'], [
            'activity_category_id' => $actCat2->id,
            'title_ar' => 'مشاركة الصفوة في منتدى الأعمال العالمي 2024',
            'title_en' => 'Alsafua Participation in Global Business Forum 2024',
            'description_ar' => 'شاركت مجموعة الصفوة بوفد رفيع المستوى في فعاليات المنتدى العالمي لمناقشة فرص الاستثمار الناشئة.',
            'description_en' => 'Alsafua Group participated with a high-level delegation in the Global Forum to discuss emerging investment opportunities.',
            'image' => null,
            'status' => 'published',
            'order' => 1,
            'created_by' => $adminId
        ]);

        Activity::updateOrCreate(['slug' => 'green-initiative'], [
            'activity_category_id' => $actCat->id,
            'title_ar' => 'إطلاق مبادرة الصفوة الخضراء',
            'title_en' => 'Launching Alsafua Green Initiative',
            'description_ar' => 'ضمن التزامنا بالاستدامة، أطلقنا مبادرة للتشجير ودعم مشاريع الطاقة المتجددة.',
            'description_en' => 'As part of our commitment to sustainability, we launched an initiative for afforestation and supporting renewable energy projects.',
            'image' => null,
            'status' => 'published',
            'order' => 2,
            'created_by' => $adminId
        ]);

        // --- Gallery ---
        $galCat = GalleryCategory::updateOrCreate(['slug' => 'projects'], [
            'name_ar' => 'صور المشاريع',
            'name_en' => 'Projects Gallery',
            'status' => 'active'
        ]);
        for ($i = 1; $i <= 3; $i++) {
            GalleryImage::updateOrCreate(['image' => 'demo/gallery' . $i . '.jpg'], [
                'gallery_category_id' => $galCat->id,
                'title_ar' => 'مشروع رقم ' . $i,
                'title_en' => 'Project No ' . $i,
                'status' => 'published',
                'order' => $i,
                'created_by' => $adminId
            ]);
        }

        // --- Branches ---
        Branch::updateOrCreate(['name_ar' => 'الفرع الرئيسي - صنعاء'], [
            'name_en' => 'Main Branch - Sanaa',
            'address_ar' => 'صنعاء، شارع الستين، برج الصفوة',
            'address_en' => 'Sanaa, Al-Sitteen St, Alsafua Tower',
            'phone' => '+967 1 123456',
            'email' => 'main@alsafua.com',
            'working_hours_ar' => '8:00 صباحاً - 8:00 مساءً',
            'working_hours_en' => '8:00 AM - 8:00 PM',
            'status' => 'active',
            'order' => 1
        ]);

        Branch::updateOrCreate(['name_ar' => 'فرع عدن'], [
            'name_en' => 'Aden Branch',
            'address_ar' => 'عدن، كريتر، مجمع عدن التجاري',
            'address_en' => 'Aden, Crater, Aden Commercial Mall',
            'phone' => '+967 2 654321',
            'email' => 'aden@alsafua.com',
            'status' => 'active',
            'order' => 2
        ]);

        // --- Pages ---
        Page::updateOrCreate(['slug' => 'about-us'], [
            'title_ar' => 'من نحن',
            'title_en' => 'About Us',
            'content_ar' => '<h3>قصة نجاحنا</h3><p>شركة الصفوة هي شركة رائدة في مجال التجارة والاستثمار، تأسست برؤية طموحة للمساهمة في بناء اقتصاد قوي ومستدام. نحن فخورون بقيمنا التي تقوم على النزاهة، الجودة، والابتكار.</p>',
            'content_en' => '<h3>Our Success Story</h3><p>Alsafua is a leading company in trading and investment, founded with an ambitious vision to contribute to building a strong and sustainable economy. We are proud of our values based on integrity, quality, and innovation.</p>',
            'image' => 'demo/about.jpg',
            'status' => 'published',
            'order' => 1,
            'created_by' => $adminId
        ]);
    }
}
