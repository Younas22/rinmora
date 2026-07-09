<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $table = 'sales_payment_gateways';

    protected $fillable = [
        'code', 'name', 'icon_class', 'is_enabled', 'is_connected', 'sort_order',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_connected' => 'boolean',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'gateway_id');
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_connected) {
            return 'Not Connected';
        }

        return $this->code === 'cod' ? 'Enabled' : 'Connected';
    }
}
