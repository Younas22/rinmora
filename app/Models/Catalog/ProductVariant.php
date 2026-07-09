<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'catalog_product_variants';

    protected $fillable = [
        'product_id', 'sku', 'price', 'quantity', 'option_values',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'option_values' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getLabelAttribute(): string
    {
        return collect($this->option_values ?? [])->implode(' / ');
    }

    public function getEffectivePriceAttribute(): string
    {
        return $this->price ?? $this->product?->price;
    }
}
