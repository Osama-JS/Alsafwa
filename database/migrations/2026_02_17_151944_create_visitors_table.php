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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->string('page_url');
            $table->string('referer')->nullable();
            $table->timestamp('visited_at');

            $table->index('ip_address');
            $table->index('visited_at');
            $table->index('page_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
