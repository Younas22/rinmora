<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    protected $table = 'sales_shipping_zones';

    protected $fillable = [
        'name', 'countries', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function methods()
    {
        return $this->hasMany(ShippingMethod::class, 'zone_id')->orderBy('sort_order');
    }
}
