<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SeoMeta extends Model
{
    protected $table = 'cms_seo_meta';

    protected $fillable = [
        'page_url', 'page_label', 'page_type', 'meta_title', 'meta_description',
        'focus_keyword', 'canonical_url', 'og_image_path', 'twitter_card_type',
        'schema_type', 'schema_json',
    ];

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image_path ? Storage::disk('public_uploads')->url($this->og_image_path) : null;
    }

    public function getMetaTitleOkAttribute(): bool
    {
        $len = strlen($this->meta_title ?? '');

        return $len >= 30 && $len <= 60;
    }

    public function getMetaDescriptionOkAttribute(): bool
    {
        $len = strlen($this->meta_description ?? '');

        return $len >= 70 && $len <= 160;
    }

    /**
     * Deterministic heuristic (title-ok + description-ok + has-focus-keyword,
     * scaled to 100) — an estimate for the admin UI, not a real crawl score.
     */
    public function getSeoScoreAttribute(): int
    {
        $score = 0;
        $score += $this->meta_title_ok ? 40 : 0;
        $score += $this->meta_description_ok ? 40 : 0;
        $score += $this->focus_keyword ? 20 : 0;

        return $score;
    }
}
