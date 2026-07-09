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
        // No doctrine/dbal installed, so enum changes need raw SQL.
        DB::statement("ALTER TABLE catalog_inventory_movements MODIFY reason ENUM('restock','damaged','recount','return_to_stock','order_placed','order_cancelled') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE catalog_inventory_movements MODIFY reason ENUM('restock','damaged','recount','return_to_stock') NOT NULL");
    }
};
