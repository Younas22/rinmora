<?php

namespace App\Models\Sales;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'sales_orders';

    protected $fillable = [
        'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'shipping_name', 'shipping_address_line1', 'shipping_address_line2',
        'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country', 'shipping_phone',
        'billing_same_as_shipping', 'billing_name', 'billing_address_line1', 'billing_address_line2',
        'billing_city', 'billing_state', 'billing_zip', 'billing_country', 'billing_phone',
        'status', 'payment_status',
        'subtotal', 'shipping_amount', 'discount_amount', 'tax_amount', 'total',
        'customer_note',
    ];

    protected $casts = [
        'billing_same_as_shipping' => 'boolean',
        'subtotal' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::created(function (Order $order) {
            if (empty($order->order_number)) {
                $order->order_number = 'RIN-'.(20000 + $order->id);
                $order->saveQuietly();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function events()
    {
        return $this->hasMany(OrderEvent::class, 'order_id')->latest();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'order_id')->latestOfMany();
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class, 'order_id');
    }

    public function getShippingStatusAttribute(): string
    {
        return match ($this->status) {
            'shipped' => 'In Transit',
            'delivered' => 'Shipped',
            'cancelled', 'returned', 'refunded' => '—',
            default => 'Not Shipped',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'delivered' => 'success',
            'shipped' => 'info',
            'processing', 'packed' => 'warning',
            'cancelled', 'returned' => 'black/50',
            'refunded' => 'danger',
            default => 'black/50',
        };
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'success',
            'refunded' => 'danger',
            default => 'warning',
        };
    }

    public function getShippingStatusColorAttribute(): string
    {
        return match ($this->shipping_status) {
            'Shipped' => 'black/50',
            'In Transit' => 'info',
            default => 'black/50',
        };
    }
}
