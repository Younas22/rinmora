<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CategoryMedia extends Model
{
    use HasFactory;

    protected $table = 'catalog_category_media';

    protected $fillable = [
        'category_id', 'path', 'type', 'is_cover', 'sort_order',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public_uploads')->url($this->path);
    }
}
