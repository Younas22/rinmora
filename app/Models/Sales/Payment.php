<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'sales_payments';

    protected $fillable = [
        'order_id', 'gateway_id', 'transaction_ref', 'status', 'amount',
        'card_brand', 'card_last_four', 'notes', 'proof_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }

    public function getCardLabelAttribute(): ?string
    {
        if (!$this->card_brand || !$this->card_last_four) {
            return null;
        }

        return "{$this->card_brand} ending in {$this->card_last_four}";
    }

    public function getProofUrlAttribute(): ?string
    {
        return $this->proof_path ? Storage::disk('public_uploads')->url($this->proof_path) : null;
    }
}
