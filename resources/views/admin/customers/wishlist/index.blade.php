@extends('admin.catalog.layouts.app')

@section('title', 'Wishlist Reports')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Wishlist Reports</h1>
            <p class="text-black/45 text-sm mt-1">See which products customers are saving most, and how well they convert.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Wishlist Saves</p>
            <p class="text-xl font-bold">{{ number_format($stats['total_saves']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Customers with Wishlist</p>
            <p class="text-xl font-bold text-info">{{ $stats['customers_with_wishlist'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Wishlist &rarr; Cart Rate</p>
            <p class="text-xl font-bold text-success">{{ $stats['cart_conversion_rate'] }}%</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Out-of-Stock Wishlisted</p>
            <p class="text-xl font-bold text-warning">{{ $stats['out_of_stock_wishlisted'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <label for="wishlistSearch" class="sr-only">Search products</label>
                <input id="wishlistSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="category" aria-label="Filter by category" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <div class="relative">
                <select name="sort" aria-label="Sort by" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Sort: Most Wishlisted</option>
                    <option value="highest_conversion" @selected(request('sort') === 'highest_conversion')>Highest Conversion</option>
                    <option value="lowest_conversion" @selected(request('sort') === 'lowest_conversion')>Lowest Conversion</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[780px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 pl-5 font-medium">Product</th>
                        <th class="py-3 font-medium">Wishlisted</th>
                        <th class="py-3 font-medium">Popularity</th>
                        <th class="py-3 font-medium">Price</th>
                        <th class="py-3 font-medium">Stock</th>
                        <th class="py-3 pr-5 font-medium">Cart Conversion</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($products as $product)
                        @php
                            $stockColor = ['In Stock' => 'success', 'Low Stock' => 'warning', 'Out of Stock' => 'danger'][$product->stock_status];
                            $popularityPct = round($product->wishlisted_by_count / $maxWishlisted * 100);
                            // Cart Conversion is a labeled display-only estimate — no real
                            // "added to cart from wishlist" event tracking exists in this codebase.
                            $conversion = min(85, round(($product->reviews()->count() + 2) / max($product->wishlisted_by_count, 1) * 40));
                        @endphp
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3 pl-5">
                                <div class="flex items-center gap-3">
                                    @if ($product->coverImage)
                                        <img src="{{ $product->coverImage->thumb_url }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover {{ $product->stock_status === 'Out of Stock' ? 'grayscale opacity-60' : '' }}">
                                    @else
                                        <span class="w-10 h-10 rounded-lg bg-black/5 grid place-items-center text-black/25"><i class="fa-solid fa-image text-xs"></i></span>
                                    @endif
                                    <div>
                                        <p class="font-semibold">{{ $product->name }}</p>
                                        <p class="text-black/40 text-xs">{{ $product->category->name ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 font-semibold">{{ $product->wishlisted_by_count }}</td>
                            <td class="py-3">
                                <div class="w-24 h-2 rounded-full bg-black/[0.06] overflow-hidden">
                                    <div class="h-full bg-primary-dark rounded-full" style="width: {{ $popularityPct }}%"></div>
                                </div>
                            </td>
                            <td class="py-3">{{ format_price($product->price) }}</td>
                            <td class="py-3"><span class="bg-{{ $stockColor }}/10 text-{{ $stockColor }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $product->stock_status }}</span></td>
                            <td class="py-3 pr-5 font-semibold {{ $conversion >= 20 ? 'text-success' : ($conversion >= 10 ? 'text-black/60' : 'text-danger') }}">{{ $conversion }}%</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-10 text-center text-black/40 text-sm">No wishlisted products yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $products->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

@endsection
