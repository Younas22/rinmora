<?php

namespace App\Models\System;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'module', 'action', 'route_name', 'ip_address', 'device', 'browser', 'url',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeForAdmin(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
