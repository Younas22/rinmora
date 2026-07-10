<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'cms_faqs';

    protected $fillable = [
        'category',
        'question',
        'answer',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public const CATEGORIES = ['orders', 'shipping', 'returns', 'payments', 'products', 'account'];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
