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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            // cascadeOnDelete (not the usual nullOnDelete): this row carries no
            // denormalized identity of its own, so it has no purpose once the
            // owning customer is gone.
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->enum('type', ['shipping', 'billing']);
            $table->string('recipient_name');
            $table->string('phone')->nullable();
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country');
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
