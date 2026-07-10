<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $table = 'cms_redirects';

    protected $fillable = [
        'from_url', 'to_url', 'type', 'hits', 'status',
    ];

    public static function createFromNotFound(NotFoundLog $log, string $to, string $type = '301'): self
    {
        return self::create([
            'from_url' => $log->url,
            'to_url' => $to,
            'type' => $type,
            'status' => 'active',
        ]);
    }
}
