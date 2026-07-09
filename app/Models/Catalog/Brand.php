<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'catalog_brands';

    protected $fillable = [
        'name', 'slug', 'logo_path', 'description', 'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Brand $brand) {
            if (empty($brand->slug)) {
                $brand->slug = $brand->generateUniqueSlug($brand->name);
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

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? Storage::disk('public_uploads')->url($this->logo_path) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
