<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'cms_media';

    protected $fillable = [
        'path', 'thumb_path', 'original_name', 'alt_text', 'mime_type', 'size', 'type', 'folder',
    ];

    public function getUrlAttribute(): string
    {
        return Storage::disk('public_uploads')->url($this->path);
    }

    public function getThumbUrlAttribute(): string
    {
        return $this->thumb_path
            ? Storage::disk('public_uploads')->url($this->thumb_path)
            : $this->url;
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1).' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1).' KB';
        }

        return $bytes.' B';
    }
}
