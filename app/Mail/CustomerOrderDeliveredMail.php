<?php

namespace App\Mail;

use App\Models\Sales\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerOrderDeliveredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Order Has Arrived — {$this->order->order_number}",
        );
    }

    public function content(): Content
    {
        $this->order->loadMissing('items.product');

        $frontendUrl = rtrim(config('services.frontend.url'), '/');

        $items = $this->order->items->map(fn ($item) => [
            'name' => $item->product_name,
            'variant_label' => $item->variant_label,
            'quantity' => $item->quantity,
            'review_url' => $item->product?->slug ? "{$frontendUrl}/products/{$item->product->slug}#reviews" : null,
        ]);

        return new Content(
            view: 'emails.customer-order-delivered',
            with: [
                'order' => $this->order,
                'items' => $items,
            ],
        );
    }
}
