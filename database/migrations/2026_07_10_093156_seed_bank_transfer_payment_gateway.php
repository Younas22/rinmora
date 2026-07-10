<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('sales_payment_gateways')->updateOrInsert(
            ['code' => 'bank_transfer'],
            [
                'name' => 'Bank Transfer',
                'icon_class' => 'fa-solid fa-building-columns',
                'is_enabled' => true,
                'is_connected' => true,
                'sort_order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('sales_payment_gateways')->where('code', 'bank_transfer')->delete();
    }
};
