<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'service',
        'subject',
        'message',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope to get new contacts
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    // Scope to get read contacts
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    // Scope to get replied contacts
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update(['status' => 'read']);
    }

    // Mark as replied
    public function markAsReplied()
    {
        $this->update(['status' => 'replied']);
    }
}