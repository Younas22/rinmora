<?php

use App\Models\Currency;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'symbol_position' => 'before', 'decimal_places' => 2, 'exchange_rate' => 1, 'is_base' => true, 'is_active' => true],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'symbol_position' => 'before', 'decimal_places' => 2, 'exchange_rate' => 0.92],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'symbol_position' => 'before', 'decimal_places' => 2, 'exchange_rate' => 0.79],
            ['code' => 'PKR', 'name' => 'Pakistani Rupee', 'symbol' => 'Rs', 'symbol_position' => 'before', 'decimal_places' => 0, 'exchange_rate' => 278.5],
            ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹', 'symbol_position' => 'before', 'decimal_places' => 2, 'exchange_rate' => 83.3],
            ['code' => 'AED', 'name' => 'UAE Dirham', 'symbol' => 'AED', 'symbol_position' => 'before', 'decimal_places' => 2, 'exchange_rate' => 3.67],
            ['code' => 'SAR', 'name' => 'Saudi Riyal', 'symbol' => 'SAR', 'symbol_position' => 'before', 'decimal_places' => 2, 'exchange_rate' => 3.75],
            ['code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'CA$', 'symbol_position' => 'before', 'decimal_places' => 2, 'exchange_rate' => 1.36],
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$', 'symbol_position' => 'before', 'decimal_places' => 2, 'exchange_rate' => 1.52],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥', 'symbol_position' => 'before', 'decimal_places' => 0, 'exchange_rate' => 149.5],
        ];

        foreach ($currencies as $i => $data) {
            Currency::updateOrCreate(
                ['code' => $data['code']],
                $data + ['is_base' => false, 'is_active' => false, 'sort_order' => $i]
            );
        }
    }

    public function down(): void
    {
        Currency::whereIn('code', ['USD', 'EUR', 'GBP', 'PKR', 'INR', 'AED', 'SAR', 'CAD', 'AUD', 'JPY'])->delete();
    }
};
