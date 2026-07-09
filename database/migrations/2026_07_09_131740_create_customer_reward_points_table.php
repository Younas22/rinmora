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
        Schema::create('customer_reward_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Summary row, not a ledger — no adjustment/redemption UI exists
            // yet to justify a transaction table. Tier is read from
            // users.customer_tier directly, not duplicated here.
            $table->unsignedInteger('points_balance')->default(0);
            $table->unsignedInteger('lifetime_earned')->default(0);
            $table->unsignedInteger('redeemed')->default(0);
            $table->unsignedInteger('expiring_soon')->default(0);
            $table->date('expires_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_reward_points');
    }
};
