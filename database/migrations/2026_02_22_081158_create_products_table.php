<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
