<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Collection extends Model
{
    use HasFactory;

    protected $table = 'catalog_collections';

    protected $fillable = [
        'name', 'slug', 'description', 'type', 'cover_image_path', 'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Collection $collection) {
            if (empty($collection->slug)) {
                $collection->slug = $collection->generateUniqueSlug($collection->name);
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
        return $this->hasMany(Product::class, 'collection_id');
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image_path ? Storage::disk('public_uploads')->url($this->cover_image_path) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
