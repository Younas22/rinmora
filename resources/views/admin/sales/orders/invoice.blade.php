@extends('admin.sales.layouts.print')

@section('title', 'Invoice · Order #'.$order->order_number)

@section('content')

    <div class="print-card bg-white rounded-3xl shadow-card p-8 md:p-10">

        <div class="flex items-start justify-between gap-4 mb-8 pb-8 border-b border-black/10">
            <div>
                @php
                    $invoiceLogoPath = \App\Models\Setting::getValue('logo_path', 'store_branding');
                    $invoiceLogoUrl = $invoiceLogoPath ? \Illuminate\Support\Facades\Storage::disk('public_uploads')->url($invoiceLogoPath) : asset('public/logo-01.png');
                    $storeInfo = \App\Models\Setting::getByGroup('store_info');
                @endphp
                <img src="{{ $invoiceLogoUrl }}" alt="{{ $storeInfo['biz_name'] ?? 'Rinmora' }}" class="h-10 w-auto mb-3">
                <p class="font-semibold text-sm">{{ $storeInfo['biz_name'] ?? 'Rinmora' }}</p>
                @if (!empty($storeInfo['biz_address']))
                    <p class="text-black/50 text-xs">{{ $storeInfo['biz_address'] }}</p>
                @endif
                @if (!empty($storeInfo['biz_email']) || !empty($storeInfo['biz_phone']))
                    <p class="text-black/50 text-xs">{{ $storeInfo['biz_email'] ?? '' }}{{ !empty($storeInfo['biz_email']) && !empty($storeInfo['biz_phone']) ? ' · ' : '' }}{{ $storeInfo['biz_phone'] ?? '' }}</p>
                @endif
            </div>
            <div class="text-right">
                <h1 class="text-xl font-bold">Invoice</h1>
                <p class="text-black/50 text-xs mt-1">Invoice #INV-{{ str_replace('RIN-', '', $order->order_number) }}</p>
                <p class="text-black/50 text-xs">Order #{{ $order->order_number }}</p>
                <p class="text-black/50 text-xs">{{ $order->created_at->format('M d, Y') }}</p>
                <span class="inline-block mt-2 bg-{{ $order->payment_status_color }}/10 text-{{ $order->payment_status_color }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->payment_status) }}</span>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-black/40 text-[11px] font-semibold uppercase tracking-wide mb-1.5">Bill To</p>
                <p class="text-sm font-medium">{{ $order->billing_same_as_shipping ? $order->shipping_name : $order->billing_name }}</p>
                <p class="text-black/60 text-sm">
                    {{ $order->billing_same_as_shipping ? $order->shipping_address_line1 : $order->billing_address_line1 }},
                    {{ $order->billing_same_as_shipping ? $order->shipping_city : $order->billing_city }},
                    {{ $order->billing_same_as_shipping ? $order->shipping_country : $order->billing_country }}
                </p>
                <p class="text-black/60 text-sm">{{ $order->billing_same_as_shipping ? $order->shipping_phone : $order->billing_phone }}</p>
            </div>
            <div>
                <p class="text-black/40 text-[11px] font-semibold uppercase tracking-wide mb-1.5">Ship To</p>
                <p class="text-sm font-medium">{{ $order->shipping_name }}</p>
                <p class="text-black/60 text-sm">{{ $order->shipping_address_line1 }}, {{ $order->shipping_city }}, {{ $order->shipping_country }}</p>
                <p class="text-black/60 text-sm">{{ $order->shipping_phone }}</p>
            </div>
        </div>

        <table class="w-full text-sm mb-8">
            <thead>
                <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/10">
                    <th class="py-2 font-medium">Item</th>
                    <th class="py-2 font-medium text-center">Qty</th>
                    <th class="py-2 font-medium text-right">Unit Price</th>
                    <th class="py-2 font-medium text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @foreach ($order->items as $item)
                    <tr>
                        <td class="py-3">
                            <p class="font-medium">{{ $item->product_name }}</p>
                            <p class="text-black/40 text-xs">{{ $item->variant_label }}@if($item->variant_label && $item->sku) &middot; @endif{{ $item->sku ? 'SKU: '.$item->sku : '' }}</p>
                        </td>
                        <td class="py-3 text-center">{{ $item->quantity }}</td>
                        <td class="py-3 text-right">{{ format_price($item->unit_price) }}</td>
                        <td class="py-3 text-right font-medium">{{ format_price($item->line_total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end mb-8">
            <div class="w-full sm:w-64 space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-black/50">Subtotal</span><span>{{ format_price($order->subtotal) }}</span></div>
                <div class="flex justify-between"><span class="text-black/50">Shipping</span><span>{{ format_price($order->shipping_amount) }}</span></div>
                @if ($order->discount_amount > 0)
                    <div class="flex justify-between text-success"><span>Discount</span><span>&minus;{{ format_price($order->discount_amount) }}</span></div>
                @endif
                <div class="flex justify-between"><span class="text-black/50">Tax</span><span>{{ format_price($order->tax_amount) }}</span></div>
                <div class="flex justify-between text-base font-bold pt-2 border-t border-black/10"><span>Total Paid</span><span>{{ format_price($order->total) }}</span></div>
            </div>
        </div>

        <div class="text-center text-black/40 text-xs pt-6 border-t border-black/10">
            <p>Thank you for shopping with Rinmora.</p>
            @if ($order->latestPayment)
                <p class="mt-1">Paid via {{ $order->latestPayment->card_label ?? ucfirst($order->latestPayment->gateway->name ?? 'Payment') }} on {{ $order->latestPayment->created_at->format('M d, Y') }}</p>
            @endif
        </div>
    </div>

@endsection
