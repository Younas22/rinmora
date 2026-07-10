<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'ticket_number', 'customer_name', 'customer_email', 'subject', 'status',
    ];

    public function messages()
    {
        return $this->hasMany(SupportTicketMessage::class, 'ticket_id')->orderBy('created_at');
    }

    public static function nextTicketNumber(): string
    {
        $lastId = (int) static::max('id');

        return 'TCK-'.str_pad((string) (1000 + $lastId + 1), 4, '0', STR_PAD_LEFT);
    }
}
