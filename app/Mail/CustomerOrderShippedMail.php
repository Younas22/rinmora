<?php

namespace App\Mail;

use App\Models\Sales\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerOrderShippedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public ?string $carrier = null,
        public ?string $trackingNumber = null,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Order Has Shipped — {$this->order->order_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer-order-shipped',
            with: [
                'order' => $this->order,
                'carrier' => $this->carrier,
                'trackingNumber' => $this->trackingNumber,
                'orderUrl' => rtrim(config('services.frontend.url'), '/').'/account/orders/'.$this->order->order_number,
            ],
        );
    }
}
