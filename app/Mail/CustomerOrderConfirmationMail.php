<?php

namespace App\Mail;

use App\Models\Sales\BankAccount;
use App\Models\Sales\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class CustomerOrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param Collection<int, BankAccount> $bankAccounts
     */
    public function __construct(public Order $order, public Collection $bankAccounts)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Order Confirmed — {$this->order->order_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer-order-confirmation',
            with: [
                'order' => $this->order,
                'bankAccounts' => $this->bankAccounts,
                'isBankTransfer' => $this->order->latestPayment?->gateway?->code === 'bank_transfer',
            ],
        );
    }
}
