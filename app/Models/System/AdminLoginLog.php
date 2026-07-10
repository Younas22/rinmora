<?php

namespace App\Models\System;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AdminLoginLog extends Model
{
    protected $fillable = [
        'user_id', 'email_attempted', 'status', 'ip_address', 'location', 'device', 'browser',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
