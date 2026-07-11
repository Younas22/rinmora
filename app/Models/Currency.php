<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'symbol_position',
        'decimal_places',
        'exchange_rate',
        'is_base',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:6',
        'is_base' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static ?self $activeCache = null;

    /**
     * The single currently-selected display currency (Settings > Currency).
     * Cached per-request so format_price() doesn't hit the DB on every call.
     */
    public static function active(): ?self
    {
        return static::$activeCache ??= static::where('is_active', true)->first();
    }

    public static function forgetActiveCache(): void
    {
        static::$activeCache = null;
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('code');
    }

    /**
     * Make this the active display currency and clear all others.
     */
    public function activate(): void
    {
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
        static::forgetActiveCache();
    }
}
