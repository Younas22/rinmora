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
        Schema::create('catalog_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('catalog_categories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('catalog_brands')->nullOnDelete();
            $table->foreignId('collection_id')->nullable()->constrained('catalog_collections')->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->decimal('price', 10, 2);
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->decimal('cost_per_item', 10, 2)->nullable();

            $table->string('sku')->nullable()->unique();
            $table->string('barcode')->nullable();

            $table->integer('quantity')->default(0);
            $table->integer('low_stock_threshold')->default(10);
            $table->boolean('track_quantity')->default(true);
            $table->boolean('allow_backorders')->default(false);
            $table->boolean('charge_tax')->default(true);

            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('tags')->nullable();

            $table->enum('status', ['active', 'draft', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_visible')->default(true);

            $table->timestamps();

            $table->index('slug');
            $table->index('sku');
            $table->index('category_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_products');
    }
};
