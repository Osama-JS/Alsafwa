<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $colors = [
            // Theme Colors (Frontend)
            ['key' => 'theme_primary_color',  'value' => '#1a3a6b', 'type' => 'string', 'group' => 'appearance'],
            ['key' => 'theme_primary_dark',   'value' => '#0f2347', 'type' => 'string', 'group' => 'appearance'],
            ['key' => 'theme_primary_light',  'value' => '#2a5298', 'type' => 'string', 'group' => 'appearance'],
            ['key' => 'theme_accent_color',   'value' => '#c9a84c', 'type' => 'string', 'group' => 'appearance'],
            ['key' => 'theme_accent_dark',    'value' => '#a8893a', 'type' => 'string', 'group' => 'appearance'],
            ['key' => 'theme_accent_light',   'value' => '#e8c96a', 'type' => 'string', 'group' => 'appearance'],
            // Company extras
            ['key' => 'company_tagline_ar',   'value' => 'للتجارة والاستثمار',         'type' => 'string', 'group' => 'company'],
            ['key' => 'company_tagline_en',   'value' => 'For Trade and Investment',   'type' => 'string', 'group' => 'company'],
            // Contact extras
            ['key' => 'company_working_hours_ar', 'value' => 'السبت - الخميس: 8ص - 5م', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'company_working_hours_en', 'value' => 'Sat - Thu: 8AM - 5PM',     'type' => 'string', 'group' => 'contact'],
            // Social extras
            ['key' => 'social_whatsapp', 'value' => '', 'type' => 'string', 'group' => 'social'],
        ];

        foreach ($colors as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    public function down(): void
    {
        $keys = [
            'theme_primary_color', 'theme_primary_dark', 'theme_primary_light',
            'theme_accent_color', 'theme_accent_dark', 'theme_accent_light',
            'company_tagline_ar', 'company_tagline_en',
            'company_working_hours_ar', 'company_working_hours_en',
            'social_whatsapp',
        ];
        DB::table('settings')->whereIn('key', $keys)->delete();
    }
};
