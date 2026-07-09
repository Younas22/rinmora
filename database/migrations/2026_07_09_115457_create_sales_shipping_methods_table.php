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
        Schema::create('sales_shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained('sales_shipping_zones')->cascadeOnDelete();
            $table->string('name');
            $table->string('delivery_time');
            $table->decimal('rate', 10, 2)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('zone_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_shipping_methods');
    }
};
