<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_media', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('thumb_path')->nullable();
            $table->string('original_name');
            $table->string('alt_text')->nullable();
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->enum('type', ['image', 'video', 'document']);
            $table->enum('folder', ['images', 'videos', 'documents', 'products', 'banners']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_media');
    }
};
