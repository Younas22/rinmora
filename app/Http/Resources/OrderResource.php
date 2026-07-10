<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'order_number' => $this->order_number,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at?->toIso8601String(),
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'shipping_address' => [
                'name' => $this->shipping_name,
                'line1' => $this->shipping_address_line1,
                'line2' => $this->shipping_address_line2,
                'city' => $this->shipping_city,
                'state' => $this->shipping_state,
                'zip' => $this->shipping_zip,
                'country' => $this->shipping_country,
                'phone' => $this->shipping_phone,
            ],
            'items' => $this->whenLoaded('items', fn () => $this->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'product_name' => $item->product_name,
                'variant_label' => $item->variant_label,
                'image_url' => $item->product?->coverImage?->url ?? $item->product?->images->first()?->url,
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'line_total' => (float) $item->line_total,
            ])),
            'events' => $this->whenLoaded('events', fn () => $this->events->map(fn ($event) => [
                'title' => $event->title,
                'description' => $event->description,
                'created_at' => $event->created_at?->toIso8601String(),
            ])),
            'subtotal' => (float) $this->subtotal,
            'shipping_amount' => (float) $this->shipping_amount,
            'discount_amount' => (float) $this->discount_amount,
            'tax_amount' => (float) $this->tax_amount,
            'total' => (float) $this->total,
            'payment' => $this->whenLoaded('latestPayment', fn () => $this->latestPayment ? [
                'method' => $this->latestPayment->gateway?->code,
                'method_name' => $this->latestPayment->gateway?->name,
                'status' => $this->latestPayment->status,
                'proof_url' => $this->latestPayment->proof_url,
            ] : null),
        ];
    }
}
