<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $table = 'sales_shipping_methods';

    protected $fillable = [
        'zone_id', 'name', 'delivery_time', 'rate', 'sort_order',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
    ];

    public function zone()
    {
        return $this->belongsTo(ShippingZone::class, 'zone_id');
    }

    public function getRateLabelAttribute(): string
    {
        return $this->rate === null ? 'Free' : format_price((float) $this->rate);
    }
}
