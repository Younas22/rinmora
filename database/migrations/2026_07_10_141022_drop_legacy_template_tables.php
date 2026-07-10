<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Removes the leftover "Younas Dev" portfolio-template tables (blog, old
 * contact form) that shipped with this codebase but were never part of
 * Rinmora — all were empty/unused. Not reversible on purpose: this data
 * was never real Rinmora content.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('blog_comments');
        Schema::dropIfExists('blog_post_tags');
        Schema::dropIfExists('post_meta');
        Schema::dropIfExists('seo');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('blog_tags');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('contact_us');
    }

    public function down(): void
    {
        //
    }
};
