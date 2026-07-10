<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminErrorLog extends Model
{
    protected $fillable = [
        'error_type', 'message', 'endpoint', 'stack_trace', 'occurrences',
        'status', 'first_seen_at', 'last_seen_at',
    ];

    protected $casts = [
        'first_seen_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function markResolved(): void
    {
        $this->update(['status' => 'resolved']);
    }
}
