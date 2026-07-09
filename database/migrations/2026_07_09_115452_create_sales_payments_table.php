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
        Schema::create('sales_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('sales_orders')->cascadeOnDelete();
            $table->foreignId('gateway_id')->nullable()->constrained('sales_payment_gateways')->nullOnDelete();
            $table->string('transaction_ref')->unique();
            $table->enum('status', ['success', 'failed', 'refunded'])->default('success');
            $table->decimal('amount', 10, 2);
            $table->string('card_brand')->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_payments');
    }
};
