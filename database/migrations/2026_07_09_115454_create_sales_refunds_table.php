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
        Schema::create('sales_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('sales_orders')->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('sales_payments')->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('reason')->nullable();
            $table->enum('stage', ['requested', 'approved', 'processed'])->default('requested');
            $table->timestamps();

            $table->index('order_id');
            $table->index('stage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_refunds');
    }
};
