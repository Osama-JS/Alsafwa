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
        Schema::create('partners', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('name_ar');
            $blueprint->string('name_en');
            $blueprint->string('logo');
            $blueprint->string('url')->nullable();
            $blueprint->enum('status', ['active', 'inactive'])->default('active');
            $blueprint->integer('order')->default(0);
            $blueprint->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $blueprint->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
