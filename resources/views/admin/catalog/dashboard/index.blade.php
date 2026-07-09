@extends('admin.catalog.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Dashboard</h1>
            <p class="text-black/45 text-sm mt-1">Welcome back — here's what's happening with your catalog today.</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <a href="{{ route('admin.catalog.products.create') }}" class="hover-lift flex items-center gap-3 bg-white rounded-2xl shadow-card p-4 text-left">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center shrink-0"><i class="fa-solid fa-plus text-primary-dark text-xs"></i></span>
            <span class="text-sm font-semibold">Add Product</span>
        </a>
        <a href="{{ route('admin.catalog.categories.index') }}" class="hover-lift flex items-center gap-3 bg-white rounded-2xl shadow-card p-4 text-left">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center shrink-0"><i class="fa-solid fa-folder-plus text-primary-dark text-xs"></i></span>
            <span class="text-sm font-semibold">Add Category</span>
        </a>
        <a href="{{ route('admin.catalog.inventory.index') }}" class="hover-lift flex items-center gap-3 bg-white rounded-2xl shadow-card p-4 text-left">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center shrink-0"><i class="fa-solid fa-warehouse text-primary-dark text-xs"></i></span>
            <span class="text-sm font-semibold">Adjust Stock</span>
        </a>
        <a href="{{ route('admin.catalog.reviews.index') }}" class="hover-lift flex items-center gap-3 bg-white rounded-2xl shadow-card p-4 text-left">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center shrink-0"><i class="fa-regular fa-star text-primary-dark text-xs"></i></span>
            <span class="text-sm font-semibold">Moderate Reviews</span>
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 md:gap-4 mb-6">
        <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-bag-shopping text-primary-dark text-xs"></i></span>
            <p class="text-xl font-bold">{{ $stats['total_products'] }}</p>
            <p class="text-black/45 text-xs mt-0.5">Total Products</p>
        </div>
        <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-circle-check text-primary-dark text-xs"></i></span>
            <p class="text-xl font-bold">{{ $stats['active_products'] }}</p>
            <p class="text-black/45 text-xs mt-0.5">Active Products</p>
        </div>
        <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
            <span class="w-9 h-9 rounded-full bg-danger/15 grid place-items-center mb-3"><i class="fa-solid fa-triangle-exclamation text-danger text-xs"></i></span>
            <p class="text-xl font-bold">{{ $stats['low_stock'] }}</p>
            <p class="text-black/45 text-xs mt-0.5">Low Stock</p>
        </div>
        <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
            <span class="w-9 h-9 rounded-full bg-warning/15 grid place-items-center mb-3"><i class="fa-regular fa-star text-warning text-xs"></i></span>
            <p class="text-xl font-bold">{{ $stats['pending_reviews'] }}</p>
            <p class="text-black/45 text-xs mt-0.5">Pending Reviews</p>
        </div>
        <div class="hover-lift bg-white rounded-2xl shadow-card p-5 col-span-2 lg:col-span-1">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-tags text-primary-dark text-xs"></i></span>
            <p class="text-xl font-bold">{{ $stats['total_categories'] }} / {{ $stats['total_brands'] }}</p>
            <p class="text-black/45 text-xs mt-0.5">Categories / Brands</p>
        </div>
    </div>

    <!-- Sales/Revenue — not available until the Orders phase -->
    <div class="bg-white rounded-3xl shadow-card p-8 mb-6 text-center">
        <i class="fa-solid fa-chart-line text-black/15 text-3xl mb-3"></i>
        <p class="text-sm font-semibold">Sales &amp; revenue charts aren't available yet</p>
        <p class="text-black/45 text-xs mt-1">These populate once the Orders module is built in a later phase.</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-4">

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-sm">Low Stock Alerts</h2>
                <span class="bg-danger/10 text-danger text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $stats['low_stock'] }} items</span>
            </div>
            @if ($lowStockProducts->isEmpty())
                <p class="text-black/40 text-sm">Nothing low on stock right now.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($lowStockProducts as $product)
                        <li class="flex items-center gap-3">
                            @if ($product->coverImage)
                                <img src="{{ $product->coverImage->thumb_url }}" alt="{{ $product->name }}" class="w-11 h-11 rounded-xl object-cover">
                            @else
                                <span class="w-11 h-11 rounded-xl bg-black/5 grid place-items-center text-black/25"><i class="fa-solid fa-image text-xs"></i></span>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">{{ $product->name }}</p>
                                <p class="text-danger text-xs font-semibold">{{ $product->quantity }} units left</p>
                            </div>
                            <a href="{{ route('admin.catalog.inventory.index') }}" class="text-xs font-semibold border border-black/10 rounded-full px-3 py-1.5 hover:bg-black/5 transition">Restock</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <h2 class="font-bold text-sm mb-5">Best Selling Products</h2>
            <div class="text-center py-6">
                <i class="fa-solid fa-medal text-black/15 text-2xl mb-2"></i>
                <p class="text-black/40 text-xs">Available once the Orders module is built.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-sm">Latest Reviews</h2>
                <a href="{{ route('admin.catalog.reviews.index') }}" class="text-xs font-semibold text-black/50 hover:text-ink transition">View All</a>
            </div>
            @if ($latestReviews->isEmpty())
                <p class="text-black/40 text-sm">No reviews yet.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($latestReviews as $review)
                        <li class="flex items-start gap-3">
                            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center text-xs font-semibold shrink-0">{{ strtoupper(substr($review->customer_name, 0, 1)) }}</span>
                            <div class="min-w-0">
                                <p class="text-sm font-medium">{{ $review->customer_name }} <span class="text-primary-dark text-xs ml-1">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span></p>
                                <p class="text-black/45 text-xs truncate">{{ $review->product->name ?? 'Deleted product' }}@if($review->body) — "{{ \Illuminate\Support\Str::limit($review->body, 40) }}"@endif</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@endsection
