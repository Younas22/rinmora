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
        Schema::create('catalog_category_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('catalog_categories')->cascadeOnDelete();
            $table->string('path');
            $table->enum('type', ['image', 'video'])->default('image');
            $table->boolean('is_cover')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_category_media');
    }
};
