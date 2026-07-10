<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NotificationCampaign extends Model
{
    protected $table = 'cms_notification_campaigns';

    protected $fillable = [
        'title', 'channel', 'audience', 'subject', 'message_body', 'status',
        'sent_count', 'scheduled_at', 'sent_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function scopeChannel(Builder $query, string $channel): Builder
    {
        return $query->where('channel', $channel);
    }

    /**
     * Marks the campaign as sent for demo purposes — does not dispatch a
     * real push/email/SMS send.
     */
    public function markSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'sent_count' => $this->sent_count ?: rand(50, 500),
        ]);
    }
}
