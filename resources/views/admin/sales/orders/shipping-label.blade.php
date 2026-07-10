@extends('admin.sales.layouts.print')

@section('title', 'Shipping Label · Order #'.$order->order_number)

@section('content')

    @php
        $totalWeight = $order->items->sum(fn ($i) => (float) ($i->weight ?? 0) * $i->quantity);
        $totalItems = $order->items->sum('quantity');
        $trackingCode = 'TRK-'.str_pad($order->id, 7, '0', STR_PAD_LEFT).'PK';
        $labelLogoPath = \App\Models\Setting::getValue('logo_path', 'store_branding');
        $labelLogoUrl = $labelLogoPath ? \Illuminate\Support\Facades\Storage::disk('public_uploads')->url($labelLogoPath) : asset('public/logo-01.png');
    @endphp

    <div class="print-card bg-white rounded-3xl shadow-card p-8 border-2 border-dashed border-black/15">

        <div class="flex items-center justify-between mb-6 pb-6 border-b border-dashed border-black/15">
            <img src="{{ $labelLogoUrl }}" alt="Rinmora" class="h-8 w-auto">
            <span class="bg-ink text-white text-[11px] font-semibold px-3 py-1.5 rounded-full">Standard Shipping</span>
        </div>

        <div class="mb-6 pb-6 border-b border-dashed border-black/15">
            <p class="text-black/40 text-[11px] font-semibold uppercase tracking-wide mb-1.5">From</p>
            <p class="text-sm font-medium">Rinmora Fulfillment Center</p>
            <p class="text-black/60 text-sm">Plot 24, Korangi Industrial Area, Karachi, Sindh 74900, Pakistan</p>
        </div>

        <div class="mb-6 pb-6 border-b border-dashed border-black/15">
            <p class="text-black/40 text-[11px] font-semibold uppercase tracking-wide mb-1.5">To</p>
            <p class="text-base font-semibold">{{ $order->shipping_name }}</p>
            <p class="text-black/60 text-sm">{{ $order->shipping_address_line1 }}@if($order->shipping_address_line2), {{ $order->shipping_address_line2 }}@endif</p>
            <p class="text-black/60 text-sm">{{ $order->shipping_city }}@if($order->shipping_state), {{ $order->shipping_state }}@endif @if($order->shipping_zip) {{ $order->shipping_zip }}@endif, {{ $order->shipping_country }}</p>
            @if ($order->shipping_phone)
                <p class="text-black/60 text-sm">{{ $order->shipping_phone }}</p>
            @endif
        </div>

        <div class="grid grid-cols-3 gap-4 mb-6 pb-6 border-b border-dashed border-black/15 text-center">
            <div>
                <p class="text-black/40 text-[11px] uppercase tracking-wide">Order #</p>
                <p class="text-sm font-semibold">#{{ $order->order_number }}</p>
            </div>
            <div>
                <p class="text-black/40 text-[11px] uppercase tracking-wide">Weight</p>
                <p class="text-sm font-semibold">{{ number_format($totalWeight, 1) }} kg</p>
            </div>
            <div>
                <p class="text-black/40 text-[11px] uppercase tracking-wide">Items</p>
                <p class="text-sm font-semibold">{{ $totalItems }} pcs</p>
            </div>
        </div>

        <div class="text-center">
            <div class="flex items-end justify-center gap-[2px] h-14 mb-2">
                @for ($i = 0; $i < 40; $i++)
                    <span class="bg-ink" style="width: {{ rand(1,3) }}px; height: {{ rand(60, 100) }}%;"></span>
                @endfor
            </div>
            <p class="text-xs font-mono tracking-widest">{{ $trackingCode }}</p>
        </div>
    </div>

@endsection
