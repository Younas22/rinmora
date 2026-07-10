<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $table = 'cms_email_logs';

    protected $fillable = [
        'recipient_name', 'recipient_email', 'subject', 'status', 'opened_count',
    ];
}
