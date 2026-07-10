<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_seo_meta', function (Blueprint $table) {
            $table->id();
            $table->string('page_url')->unique();
            $table->string('page_label');
            $table->enum('page_type', ['other', 'products', 'categories', 'blog'])->default('other');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image_path')->nullable();
            $table->enum('twitter_card_type', ['summary_large_image', 'summary'])->default('summary_large_image');
            $table->string('schema_type')->nullable();
            $table->longText('schema_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_seo_meta');
    }
};
