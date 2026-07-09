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
        Schema::create('catalog_inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('catalog_products')->cascadeOnDelete();
            $table->foreignId('variant_id')->nullable()->constrained('catalog_product_variants')->cascadeOnDelete();
            $table->string('warehouse')->default('Main Warehouse');
            $table->enum('type', ['add', 'remove', 'set']);
            $table->integer('quantity_change');
            $table->enum('reason', ['restock', 'damaged', 'recount', 'return_to_stock']);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['product_id', 'variant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_inventory_movements');
    }
};
