<?php

namespace App\Models\Customers;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Address extends Model
{
    use HasFactory;

    protected $table = 'customer_addresses';

    protected $fillable = [
        'user_id', 'type', 'recipient_name', 'phone',
        'address_line1', 'address_line2', 'city', 'state', 'zip', 'country', 'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mark this address as the default for its type, unsetting any
     * sibling address of the same user+type.
     */
    public function makeDefault(): void
    {
        DB::transaction(function () {
            static::where('user_id', $this->user_id)
                ->where('type', $this->type)
                ->update(['is_default' => false]);

            $this->update(['is_default' => true]);
        });
    }
}
