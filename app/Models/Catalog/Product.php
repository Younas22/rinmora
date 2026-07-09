<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'catalog_products';

    protected $fillable = [
        'category_id', 'brand_id', 'collection_id',
        'name', 'slug', 'short_description', 'description',
        'price', 'compare_at_price', 'cost_per_item',
        'sku', 'barcode',
        'quantity', 'low_stock_threshold', 'track_quantity', 'allow_backorders', 'charge_tax',
        'weight', 'dimensions',
        'meta_title', 'meta_description', 'tags',
        'status', 'is_featured', 'is_visible',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_per_item' => 'decimal:2',
        'weight' => 'decimal:2',
        'tags' => 'array',
        'track_quantity' => 'boolean',
        'allow_backorders' => 'boolean',
        'charge_tax' => 'boolean',
        'is_featured' => 'boolean',
        'is_visible' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = $product->generateUniqueSlug($product->name);
            }
        });
    }

    protected function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $i = 2;

        while (static::where('slug', $slug)->when($this->exists, fn ($q) => $q->where('id', '!=', $this->id))->exists()) {
            $slug = "{$original}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }

    public function coverImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id')->where('is_cover', true);
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function wishlistedBy()
    {
        return $this->hasMany(\App\Models\Customers\Wishlist::class, 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'low_stock_threshold');
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->quantity <= 0) {
            return 'Out of Stock';
        }

        if ($this->quantity <= $this->low_stock_threshold) {
            return 'Low Stock';
        }

        return 'In Stock';
    }
}
