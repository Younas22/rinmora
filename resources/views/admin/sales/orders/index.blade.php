@extends('admin.catalog.layouts.app')

@section('title', 'All Orders')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">All Orders</h1>
            <p class="text-black/45 text-sm mt-1">Track and fulfill customer orders.</p>
        </div>
        <a href="{{ route('admin.sales.orders.create') }}" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
            <i class="fa-solid fa-plus text-[10px]"></i> Create Order
        </a>
    </div>

    <div class="flex gap-2 overflow-x-auto -mx-4 px-4 md:mx-0 md:px-0 mb-5">
        @foreach (['all' => 'All', 'pending' => 'Pending', 'processing' => 'Processing', 'packed' => 'Packed', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled', 'returned' => 'Returned', 'refunded' => 'Refunded'] as $key => $label)
            <a href="{{ route('admin.sales.orders.index', array_filter(request()->except('tab', 'page') + ['tab' => $key])) }}"
               class="shrink-0 text-xs font-semibold px-4 py-2 rounded-full transition {{ $tab === $key ? 'bg-ink text-white' : 'bg-white border border-black/10 hover:bg-black/5' }}">
                {{ $label }} <span class="opacity-70">({{ $counts[$key] }})</span>
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <label for="orderSearch" class="sr-only">Search orders</label>
                <input id="orderSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search by order # or customer..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="payment" aria-label="Filter by payment status" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Payment: All</option>
                    <option value="paid" @selected(request('payment') === 'paid')>Paid</option>
                    <option value="pending" @selected(request('payment') === 'pending')>Pending</option>
                    <option value="refunded" @selected(request('payment') === 'refunded')>Refunded</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[880px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 pl-5 font-medium">Order</th>
                        <th class="py-3 font-medium">Customer</th>
                        <th class="py-3 font-medium">Items</th>
                        <th class="py-3 font-medium">Payment</th>
                        <th class="py-3 font-medium">Status</th>
                        <th class="py-3 font-medium">Shipping</th>
                        <th class="py-3 font-medium">Date</th>
                        <th class="py-3 font-medium text-right">Total</th>
                        <th class="py-3 pr-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3 pl-5 font-semibold">
                                <a href="{{ route('admin.sales.orders.show', $order) }}" class="hover:text-primary-dark transition">#{{ $order->order_number }}</a>
                            </td>
                            <td class="py-3 text-black/60">{{ $order->customer_name }}</td>
                            <td class="py-3 text-black/60">{{ $order->items_count }}</td>
                            <td class="py-3"><span class="bg-{{ $order->payment_status_color }}/10 text-{{ $order->payment_status_color }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->payment_status) }}</span></td>
                            <td class="py-3">
                                @if (in_array($order->status, ['cancelled', 'returned']))
                                    <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->status) }}</span>
                                @else
                                    <span class="bg-{{ $order->status_color }}/10 text-{{ $order->status_color }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-{{ $order->shipping_status_color }}">{{ $order->shipping_status }}</td>
                            <td class="py-3 text-black/50 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="py-3 text-right font-semibold">${{ number_format($order->total, 2) }}</td>
                            <td class="py-3 pr-5 text-right">
                                <a href="{{ route('admin.sales.orders.show', $order) }}" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">View</a>
                                <a href="{{ route('admin.sales.orders.invoice', $order) }}" target="_blank" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">Invoice</a>
                                <a href="{{ route('admin.sales.orders.shipping-label', $order) }}" target="_blank" class="text-xs font-semibold text-black/50 hover:text-ink transition">Label</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-10 text-center text-black/40 text-sm">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $orders->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

@endsection
