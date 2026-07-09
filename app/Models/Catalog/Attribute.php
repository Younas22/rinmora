<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attribute extends Model
{
    use HasFactory;

    protected $table = 'catalog_attributes';

    protected $fillable = [
        'name', 'slug', 'display_type', 'use_for_variants',
    ];

    protected $casts = [
        'use_for_variants' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Attribute $attribute) {
            if (empty($attribute->slug)) {
                $attribute->slug = $attribute->generateUniqueSlug($attribute->name);
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

    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id')->orderBy('sort_order');
    }
}
