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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('writer');
            $table->date('event_date')->nullable();
            $table->string('img')->nullable();
            $table->string('url')->nullable();
            $table->text('part1')->nullable();
            $table->text('part2')->nullable();
            $table->text('part3')->nullable();
            $table->json('keyWords');
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();

            $table->enum('status', ['pending', 'reviewed', 'published'])->default('pending');
            $table->unsignedBigInteger('news_views_count')->default(0);
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
