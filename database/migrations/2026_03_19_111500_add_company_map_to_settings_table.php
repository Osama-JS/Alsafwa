<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('settings')->insert([
            'key'         => 'company_map',
            'label'       => 'خريطة الشركة (HTML Embed)',
            'value'       => null,
            'type'        => 'text',
            'group'       => 'contact',
            'description' => 'أدخل كود iFrame الخاص بخرائط جوجل هنا لعرضه في صفحة "اتصل بنا".',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->where('key', 'company_map')->delete();
    }
};
