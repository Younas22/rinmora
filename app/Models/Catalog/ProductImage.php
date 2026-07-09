<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'catalog_product_images';

    protected $fillable = [
        'product_id', 'path', 'is_cover', 'sort_order',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public_uploads')->url($this->path);
    }

    public function getThumbUrlAttribute(): string
    {
        $dir = pathinfo($this->path, PATHINFO_DIRNAME);
        $filename = pathinfo($this->path, PATHINFO_FILENAME);
        $ext = pathinfo($this->path, PATHINFO_EXTENSION);

        $thumbPath = "{$dir}/{$filename}-thumb.{$ext}";

        return Storage::disk('public_uploads')->exists($thumbPath)
            ? Storage::disk('public_uploads')->url($thumbPath)
            : $this->url;
    }
}
