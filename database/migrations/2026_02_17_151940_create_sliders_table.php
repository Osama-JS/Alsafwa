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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('subtitle_ar')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->string('image');
            $table->string('link')->nullable();
            $table->string('button_text_ar', 100)->nullable();
            $table->string('button_text_en', 100)->nullable();
            $table->integer('duration')->default(5);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
