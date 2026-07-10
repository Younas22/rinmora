<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE sales_payments MODIFY status ENUM('pending', 'success', 'failed', 'refunded') NOT NULL DEFAULT 'pending'");

        Schema::table('sales_payments', function (Blueprint $table) {
            $table->string('proof_path')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_payments', function (Blueprint $table) {
            $table->dropColumn('proof_path');
        });

        DB::statement("ALTER TABLE sales_payments MODIFY status ENUM('success', 'failed', 'refunded') NOT NULL DEFAULT 'success'");
    }
};
