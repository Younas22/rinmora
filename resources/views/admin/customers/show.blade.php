@extends('admin.catalog.layouts.app')

@section('title', $customer->full_name)

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <span class="w-14 h-14 rounded-full bg-primary/20 grid place-items-center text-lg font-bold shrink-0">{{ strtoupper(substr($customer->first_name, 0, 1)) }}</span>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl md:text-2xl font-bold">{{ $customer->full_name }}</h1>
                    @if ($customer->status === 'vip')
                        <span class="bg-ink text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">VIP</span>
                    @endif
                    <span class="bg-primary/15 text-primary-dark text-[10px] font-semibold px-2 py-0.5 rounded-full uppercase">{{ $customer->customer_tier }}</span>
                </div>
                <p class="text-black/45 text-sm mt-0.5">{{ $customer->email }} &middot; Joined {{ $customer->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-2 bg-white border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">
                <i class="fa-solid fa-arrow-left text-black/40 text-[10px]"></i> Back
            </a>
            <a href="{{ route('admin.customers.edit', $customer) }}" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-5 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                <i class="fa-solid fa-pen text-[10px]"></i> Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Orders</p>
            <p class="text-xl font-bold">{{ $customer->orders_count }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Lifetime Value</p>
            <p class="text-xl font-bold">{{ format_price($lifetimeValue) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Wishlist Items</p>
            <p class="text-xl font-bold">{{ $customer->wishlist()->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Reward Points</p>
            <p class="text-xl font-bold">{{ number_format($rewardPoints->points_balance ?? 0) }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-[1fr_320px] gap-6 items-start">
        <div class="space-y-6 min-w-0">

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-sm">Recent Orders</h2>
                    <a href="{{ route('admin.sales.orders.index') }}" class="text-xs font-semibold text-black/50 hover:text-ink transition">View All</a>
                </div>
                @forelse ($recentOrders as $order)
                    <a href="{{ route('admin.sales.orders.show', $order) }}" class="flex items-center justify-between gap-3 py-3 border-b border-black/5 last:border-0 hover:bg-black/[0.02] transition -mx-2 px-2 rounded-lg">
                        <div>
                            <p class="text-sm font-semibold">#{{ $order->order_number }}</p>
                            <p class="text-black/40 text-xs">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="bg-{{ $order->status_color }}/10 text-{{ $order->status_color }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->status) }}</span>
                        <p class="text-sm font-semibold w-20 text-right">{{ format_price($order->total) }}</p>
                    </a>
                @empty
                    <p class="text-black/40 text-sm py-4">No orders yet.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-sm">Wishlist</h2>
                    <a href="{{ route('admin.customers.wishlist.index') }}" class="text-xs font-semibold text-black/50 hover:text-ink transition">View Report</a>
                </div>
                @forelse ($wishlist as $item)
                    <div class="flex items-center gap-3 py-2.5 border-b border-black/5 last:border-0">
                        @if ($item->product?->coverImage)
                            <img src="{{ $item->product->coverImage->thumb_url }}" alt="{{ $item->product->name }}" class="w-9 h-9 rounded-lg object-cover">
                        @else
                            <span class="w-9 h-9 rounded-lg bg-black/5 grid place-items-center text-black/25"><i class="fa-solid fa-image text-xs"></i></span>
                        @endif
                        <p class="text-sm">{{ $item->product?->name ?? 'Deleted product' }}</p>
                    </div>
                @empty
                    <p class="text-black/40 text-sm py-4">No wishlist items.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Contact</h2>
                <p class="text-sm text-black/60 flex items-center gap-2 mb-1.5"><i class="fa-regular fa-envelope w-4 text-black/30"></i> {{ $customer->email }}</p>
                @if ($customer->phone)
                    <p class="text-sm text-black/60 flex items-center gap-2"><i class="fa-solid fa-phone w-4 text-black/30"></i> {{ $customer->phone }}</p>
                @endif
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-sm">Addresses</h2>
                    <a href="{{ route('admin.customers.addresses.index') }}" class="text-xs font-semibold text-black/50 hover:text-ink transition">Manage</a>
                </div>
                @forelse ($addresses as $address)
                    <div class="mb-4 pb-4 border-b border-black/5 last:border-0 last:mb-0 last:pb-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="bg-{{ $address->type === 'shipping' ? 'info' : 'primary' }}/10 text-{{ $address->type === 'shipping' ? 'info' : 'primary-dark' }} text-[10px] font-semibold px-2 py-0.5 rounded-full">{{ ucfirst($address->type) }}</span>
                            @if ($address->is_default)
                                <i class="fa-solid fa-circle-check text-success text-xs"></i>
                            @endif
                        </div>
                        <p class="text-sm text-black/60">{{ $address->address_line1 }}, {{ $address->city }}, {{ $address->country }}</p>
                    </div>
                @empty
                    <p class="text-black/40 text-sm">No saved addresses.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Reward Points</h2>
                @if ($rewardPoints)
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-black/50">Balance</span><span class="font-semibold">{{ number_format($rewardPoints->points_balance) }} pts</span></div>
                        <div class="flex justify-between"><span class="text-black/50">Lifetime Earned</span><span>{{ number_format($rewardPoints->lifetime_earned) }} pts</span></div>
                        <div class="flex justify-between"><span class="text-black/50">Redeemed</span><span>{{ number_format($rewardPoints->redeemed) }} pts</span></div>
                    </div>
                @else
                    <p class="text-black/40 text-sm">Not enrolled.</p>
                @endif
            </div>
        </div>
    </div>

@endsection
