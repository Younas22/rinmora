<?php

namespace App\Models\Customers;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardPoint extends Model
{
    use HasFactory;

    protected $table = 'customer_reward_points';

    protected $fillable = [
        'user_id', 'points_balance', 'lifetime_earned', 'redeemed', 'expiring_soon', 'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
