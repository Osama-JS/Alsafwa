<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Company Information
            ['key' => 'company_name_ar', 'value' => 'مجموعة الصفوة للتجارة والاستثمار', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_name_en', 'value' => 'Alsafua Trading & Investment Group', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_tagline_ar', 'value' => 'شريككم الموثوق في النجاح والتميز', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_tagline_en', 'value' => 'Your Trusted Partner in Success and Excellence', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_logo', 'value' => null, 'type' => 'image', 'group' => 'company'],
            ['key' => 'company_favicon', 'value' => null, 'type' => 'image', 'group' => 'company'],

            // Contact Information
            ['key' => 'company_email', 'value' => 'info@alsafua.com', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'company_phone', 'value' => '+966 11 123 4567', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'company_address_ar', 'value' => 'الرياض، المملكة العربية السعودية - البرج التجاري، الطابق 15', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'company_address_en', 'value' => 'Riyadh, Saudi Arabia - Commercial Tower, 15th Floor', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'whatsapp_number', 'value' => '+966555555555', 'type' => 'string', 'group' => 'contact'],

            // Social Media (Matched with footer.blade.php)
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/alsafua', 'type' => 'string', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/alsafua', 'type' => 'string', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/alsafua', 'type' => 'string', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/alsafua', 'type' => 'string', 'group' => 'social'],

            // Theme Settings (Matched with app.blade.php)
            ['key' => 'theme_primary_color', 'value' => '#0f2347', 'type' => 'string', 'group' => 'system'],
            ['key' => 'theme_primary_dark', 'value' => '#050a14', 'type' => 'string', 'group' => 'system'],
            ['key' => 'theme_primary_light', 'value' => '#1a3a6d', 'type' => 'string', 'group' => 'system'],
            ['key' => 'theme_accent_color', 'value' => '#c9a84c', 'type' => 'string', 'group' => 'system'],
            ['key' => 'theme_accent_dark', 'value' => '#a68a3d', 'type' => 'string', 'group' => 'system'],
            ['key' => 'theme_accent_light', 'value' => '#dbc078', 'type' => 'string', 'group' => 'system'],

            // System Settings
            ['key' => 'site_maintenance', 'value' => 'false', 'type' => 'boolean', 'group' => 'general', 'label' => 'وضع الصيانة', 'description' => 'تفعيل هذا الوضع سيمنع الزوار من تصفح الموقع وسيعرض صفحة الصيانة.'],
            ['key' => 'items_per_page', 'value' => '12', 'type' => 'string', 'group' => 'general', 'label' => 'عدد العناصر في الصفحة'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                array_merge($setting, [
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('✅ Settings created successfully!');
    }
}
