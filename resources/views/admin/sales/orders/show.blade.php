@extends('admin.catalog.layouts.app')

@section('title', 'Order #'.$order->order_number)

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-2">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl md:text-2xl font-bold">Order #{{ $order->order_number }}</h1>
                <span class="bg-{{ $order->payment_status_color }}/10 text-{{ $order->payment_status_color }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->payment_status) }}</span>
                <span class="bg-{{ $order->status_color }}/10 text-{{ $order->status_color }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->status) }}</span>
            </div>
            <p class="text-black/45 text-sm mt-1">Placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }} by {{ $order->customer_name }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.sales.orders.shipping-label', $order) }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">Shipping Label</a>
            <a href="{{ route('admin.sales.orders.invoice', $order) }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">Print Invoice</a>
        </div>
    </div>

    @if (!in_array($order->status, ['cancelled', 'delivered', 'returned', 'refunded']))
        <div class="bg-white rounded-3xl shadow-card p-5 mb-6 flex flex-wrap items-center gap-3">
            <span class="text-sm font-semibold mr-2">Update Status:</span>
            @foreach (['processing' => 'Processing', 'packed' => 'Packed', 'shipped' => 'Shipped', 'delivered' => 'Delivered'] as $value => $label)
                <form method="POST" action="{{ route('admin.sales.orders.status', $order) }}" class="update-status-form" data-status="{{ $value }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ $value }}">
                    @if ($value === 'shipped')
                        <input type="text" name="carrier" placeholder="Carrier" class="hidden shipped-field w-24 px-2 py-1.5 rounded-lg border border-black/10 text-xs">
                        <input type="text" name="tracking_number" placeholder="Tracking #" class="hidden shipped-field w-28 px-2 py-1.5 rounded-lg border border-black/10 text-xs">
                    @endif
                    @if ($value === 'delivered')
                        <input type="text" name="signee" placeholder="Signed by" class="hidden delivered-field w-28 px-2 py-1.5 rounded-lg border border-black/10 text-xs">
                    @endif
                    <button type="submit" class="text-xs font-semibold border border-black/10 rounded-full px-3.5 py-1.5 hover:bg-black/5 transition {{ $order->status === $value ? 'bg-ink text-white border-ink' : '' }}">{{ $label }}</button>
                </form>
            @endforeach
            <form method="POST" action="{{ route('admin.sales.orders.cancel', $order) }}" onsubmit="return confirm('Cancel this order and restore stock?');" class="ml-auto">
                @csrf
                <button type="submit" class="text-xs font-semibold text-danger border border-danger/20 rounded-full px-3.5 py-1.5 hover:bg-danger/5 transition">Cancel Order</button>
            </form>
        </div>
    @endif

    <div class="grid lg:grid-cols-[1fr_320px] gap-6 items-start">
        <div class="space-y-6 min-w-0">

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Order Items</h2>
                <div class="space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-3">
                            <span class="w-12 h-12 rounded-xl bg-black/5 grid place-items-center text-black/25 shrink-0"><i class="fa-solid fa-bag-shopping text-sm"></i></span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">{{ $item->product_name }}</p>
                                @if ($item->variant_label)
                                    <p class="text-black/45 text-xs">{{ $item->variant_label }}</p>
                                @endif
                                @if ($item->sku)
                                    <p class="text-black/40 text-xs">SKU: {{ $item->sku }}</p>
                                @endif
                            </div>
                            <p class="text-black/50 text-sm shrink-0">Qty {{ $item->quantity }}</p>
                            <p class="text-sm font-semibold shrink-0 w-20 text-right">${{ number_format($item->line_total, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-5">Order Timeline</h2>
                <ol class="relative border-l border-black/10 ml-2 space-y-6">
                    @foreach ($order->events as $event)
                        <li class="ml-4">
                            <span class="absolute -left-[5px] w-2.5 h-2.5 rounded-full {{ $loop->first ? 'bg-primary-dark' : 'bg-black/20' }}"></span>
                            <p class="text-sm font-medium">{{ $event->title }}</p>
                            @if ($event->description)
                                <p class="text-black/45 text-xs">{{ $event->description }}</p>
                            @endif
                            <p class="text-black/40 text-xs">{{ $event->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>

            @if ($order->customer_note)
                <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                    <h2 class="font-bold text-sm mb-3">Customer Note</h2>
                    <p class="text-black/60 text-sm italic">"{{ $order->customer_note }}"</p>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            @php
                $customerOrderCount = $order->user_id
                    ? \App\Models\Sales\Order::where('user_id', $order->user_id)->count()
                    : \App\Models\Sales\Order::where('customer_email', $order->customer_email)->count();
            @endphp
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Customer</h2>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 rounded-full bg-primary/20 grid place-items-center text-sm font-semibold shrink-0">{{ strtoupper(substr($order->customer_name, 0, 1)) }}</span>
                    <div>
                        <p class="text-sm font-medium">{{ $order->customer_name }}</p>
                        <p class="text-black/40 text-xs">{{ $customerOrderCount }} order(s)</p>
                    </div>
                </div>
                <p class="text-sm text-black/60 flex items-center gap-2 mb-1.5"><i class="fa-regular fa-envelope w-4 text-black/30"></i> {{ $order->customer_email }}</p>
                @if ($order->customer_phone)
                    <p class="text-sm text-black/60 flex items-center gap-2"><i class="fa-solid fa-phone w-4 text-black/30"></i> {{ $order->customer_phone }}</p>
                @endif
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-3">Shipping Address</h2>
                <p class="text-black/60 text-sm leading-relaxed">
                    {{ $order->shipping_name }}<br>
                    {{ $order->shipping_address_line1 }}@if($order->shipping_address_line2), {{ $order->shipping_address_line2 }}@endif<br>
                    {{ $order->shipping_city }}@if($order->shipping_state), {{ $order->shipping_state }}@endif @if($order->shipping_zip) {{ $order->shipping_zip }}@endif<br>
                    {{ $order->shipping_country }}
                    @if ($order->shipping_phone)<br>{{ $order->shipping_phone }}@endif
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-3">Billing Address</h2>
                @if ($order->billing_same_as_shipping)
                    <p class="text-black/45 text-sm italic">Same as shipping address</p>
                @else
                    <p class="text-black/60 text-sm leading-relaxed">
                        {{ $order->billing_name }}<br>
                        {{ $order->billing_address_line1 }}@if($order->billing_address_line2), {{ $order->billing_address_line2 }}@endif<br>
                        {{ $order->billing_city }}@if($order->billing_state), {{ $order->billing_state }}@endif @if($order->billing_zip) {{ $order->billing_zip }}@endif<br>
                        {{ $order->billing_country }}
                    </p>
                @endif
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Payment Summary</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-black/50">Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                    <div class="flex justify-between"><span class="text-black/50">Shipping</span><span>${{ number_format($order->shipping_amount, 2) }}</span></div>
                    @if ($order->discount_amount > 0)
                        <div class="flex justify-between text-success"><span>Discount</span><span>&minus;${{ number_format($order->discount_amount, 2) }}</span></div>
                    @endif
                    <div class="flex justify-between"><span class="text-black/50">Tax</span><span>${{ number_format($order->tax_amount, 2) }}</span></div>
                    <div class="flex justify-between text-base font-bold pt-2 border-t border-black/5"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
                </div>
                @if ($order->latestPayment)
                    <p class="text-black/45 text-xs mt-4">{{ $order->latestPayment->card_label ?? ucfirst($order->latestPayment->gateway->name ?? 'Payment') }}</p>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.update-status-form').forEach(form => {
    form.addEventListener('submit', (e) => {
      if (form.dataset.status === 'shipped') {
        const fields = form.querySelectorAll('.shipped-field');
        const hidden = [...fields].some(f => f.classList.contains('hidden'));
        if (hidden) {
          e.preventDefault();
          fields.forEach(f => f.classList.remove('hidden'));
          fields[0].focus();
        }
      }
      if (form.dataset.status === 'delivered') {
        const field = form.querySelector('.delivered-field');
        if (field && field.classList.contains('hidden')) {
          e.preventDefault();
          field.classList.remove('hidden');
          field.focus();
        }
      }
    });
  });
</script>
@endpush
