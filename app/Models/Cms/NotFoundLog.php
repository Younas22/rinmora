<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class NotFoundLog extends Model
{
    protected $table = 'cms_not_found_logs';

    protected $fillable = [
        'url', 'hit_count',
    ];
}
