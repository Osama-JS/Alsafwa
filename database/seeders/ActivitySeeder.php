<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\User;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::first()->id ?? 1;

        // Categories
        $newsCat = ActivityCategory::firstOrCreate(['slug' => 'news'], [
            'name_ar' => 'أخبار الشركة',
            'name_en' => 'Company News',
            'status' => 'active',
            'order' => 1
        ]);

        $eventsCat = ActivityCategory::firstOrCreate(['slug' => 'events'], [
            'name_ar' => 'الفعاليات',
            'name_en' => 'Events',
            'status' => 'active',
            'order' => 2
        ]);

        $csrCat = ActivityCategory::firstOrCreate(['slug' => 'csr'], [
            'name_ar' => 'المسؤولية الاجتماعية',
            'name_en' => 'Social Responsibility',
            'status' => 'active',
            'order' => 3
        ]);

        $articles = [
            [
                'category_id' => $newsCat->id,
                'title_ar' => 'شراكة استراتيجية جديدة مع ليدرز العالمية',
                'title_en' => 'New Strategic Partnership with Leaders Global',
                'description_ar' => 'أعلنت مجموعة الصفوة اليوم عن توقيع اتفاقية شراكة استراتيجية مع شركة ليدرز العالمية لتعزيز التعاون في قطاع الاستثمار والتطوير العقاري.',
                'description_en' => 'Alsafua Group announced today the signing of a strategic partnership agreement with Leaders Global to enhance cooperation in the investment and real estate development sector.',
                'slug' => 'strategic-partnership-leaders'
            ],
            [
                'category_id' => $eventsCat->id,
                'title_ar' => 'افتتاح الفرع الإقليمي الجديد في مدينة دبي',
                'title_en' => 'Opening of the New Regional Branch in Dubai',
                'description_ar' => 'احتفلت مجموعة الصفوة بافتتاح مكتبها الإقليمي الجديد في مدينة دبي، بحضور نخبة من رجال الأعمال والشركاء الاستراتيجيين.',
                'description_en' => 'Alsafua Group celebrated the opening of its new regional office in Dubai, in the presence of elite businessmen and strategic partners.',
                'slug' => 'new-dubai-branch-opening'
            ],
            [
                'category_id' => $newsCat->id,
                'title_ar' => 'الصفوة تحصد جائزة التميز في الاستثمار المباشر',
                'title_en' => 'Alsafua Wins Excellence in Private Equity Award',
                'description_ar' => 'تم تكريم مجموعة الصفوة بجائزة التميز في الاستثمار المباشر لعام 2024، تقديراً لأدائها الاستثنائي ومساهمتها في نمو الاقتصاد المحلي.',
                'description_en' => 'Alsafua Group was honored with the Excellence in Private Equity Award for 2024, in recognition of its exceptional performance and contribution to the growth of the local economy.',
                'slug' => 'excellence-investment-award'
            ],
            [
                'category_id' => $csrCat->id,
                'title_ar' => 'إطلاق حملة "دعم المجتمع" لدعم التعليم التقني',
                'title_en' => 'Launching "Community Support" Campaign for Technical Education',
                'description_ar' => 'ضمن برامج المسؤولية الاجتماعية، أطلقت الصفوة حملة شاملة لدعم مراكز التعليم التقني وتوفير منح دراسية للطلاب المتميزين.',
                'description_en' => 'As part of its social responsibility programs, Alsafua launched a comprehensive campaign to support technical education centers and provide scholarships for outstanding students.',
                'slug' => 'community-support-campaign'
            ],
            [
                'category_id' => $newsCat->id,
                'title_ar' => 'إطلاق خط الإنتاج الجديد للأجهزة الإلكترونية المتقدمة',
                'title_en' => 'Launch of New Production Line for Advanced Electronics',
                'description_ar' => 'كشفت الصفوة عن أحدث خطوط إنتاجها في قطاع التكنولوجيا، والذي يضم أجهزة ذكية متطورة تلبي احتياجات السوق العصرية.',
                'description_en' => 'Alsafua revealed its latest production line in the technology sector, featuring advanced smart devices that meet modern market needs.',
                'slug' => 'new-electronics-production-line'
            ],
            [
                'category_id' => $eventsCat->id,
                'title_ar' => 'الصفوة ترعى المؤتمر الدولي للابتكار التجاري',
                'title_en' => 'Alsafua Sponsors International Business Innovation Conference',
                'description_ar' => 'شاركت مجموعة الصفوة كراعٍ ذهبي في فعاليات المؤتمر الدولي للابتكار التجاري، مؤكدةً دورها في دعم الأفكار الريادية والمستدامة.',
                'description_en' => 'Alsafua Group participated as a gold sponsor in the International Business Innovation Conference, confirming its role in supporting entrepreneurial and sustainable ideas.',
                'slug' => 'innovation-conference-sponsorship'
            ],
            [
                'category_id' => $csrCat->id,
                'title_ar' => 'مبادرة "بيئة خضراء" تتجاوز أهدافها لعام 2024',
                'title_en' => '"Green Environment" Initiative Surpasses 2024 Goals',
                'description_ar' => 'حققت مبادرة الصفوة للبيئة الخضراء نتائج قياسية هذا العام، حيث تم غرس أكثر من 50,000 شجرة في مختلف مناطق العمليات.',
                'description_en' => 'Alsafua\'s Green Environment initiative achieved record results this year, with more than 50,000 trees planted across various operation areas.',
                'slug' => 'green-environment-milestones'
            ],
            [
                'category_id' => $newsCat->id,
                'title_ar' => 'اعتماد معايير الجودة العالمية ISO في كافة الأقسام',
                'title_en' => 'Adoption of ISO International Quality Standards in All Departments',
                'description_ar' => 'أعلنت الصفوة عن حصول كافة أقسامها الإدارية والتشغيلية على شهادة الجودة العالمية ISO، تعزيزاً لكفاءة الخدمات المقدمة للعملاء.',
                'description_en' => 'Alsafua announced that all its administrative and operational departments have received the ISO International Quality Certification, enhancing the efficiency of services provided to customers.',
                'slug' => 'iso-certification-achievement'
            ],
        ];

        foreach ($articles as $index => $art) {
            Activity::updateOrCreate(['slug' => $art['slug']], [
                'activity_category_id' => $art['category_id'],
                'title_ar' => $art['title_ar'],
                'title_en' => $art['title_en'],
                'description_ar' => '<p>' . $art['description_ar'] . '</p><p>نحن في الصفوة نؤمن بأن النجاح يبدأ من التخطيط السليم والتنفيذ المتقن، وهذا الخبر يعكس طموحنا المستمر نحو الريادة والتميز في كل ما نقدمه لعملائنا وشركائنا.</p>',
                'description_en' => '<p>' . $art['description_en'] . '</p><p>We at Alsafua believe that success begins with proper planning and master execution, and this news reflects our continuous ambition towards leadership and excellence in everything we offer to our customers and partners.</p>',
                'status' => 'published',
                'order' => $index + 1,
                'created_by' => $adminId,
                'image' => null // Placeholder image will be used in view if null
            ]);
        }
    }
}
