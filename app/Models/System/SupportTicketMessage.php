<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class SupportTicketMessage extends Model
{
    protected $fillable = [
        'ticket_id', 'sender_type', 'sender_name', 'is_internal_note', 'body',
    ];

    protected $casts = [
        'is_internal_note' => 'boolean',
    ];

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }
}
