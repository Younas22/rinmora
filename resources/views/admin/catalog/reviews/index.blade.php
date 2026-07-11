@extends('admin.catalog.layouts.app')

@section('title', 'Reviews')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Reviews</h1>
            <p class="text-black/45 text-sm mt-1">Moderate customer reviews across your catalog.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-[1fr_1fr] gap-4 mb-6">
        <div class="grid grid-cols-3 gap-3 md:gap-4">
            <div class="bg-white rounded-2xl shadow-card p-5">
                <p class="text-black/45 text-xs mb-1">Total</p>
                <p class="text-xl font-bold">{{ $counts['all'] }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-card p-5">
                <p class="text-black/45 text-xs mb-1">Pending</p>
                <p class="text-xl font-bold text-warning">{{ $counts['pending'] }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-card p-5">
                <p class="text-black/45 text-xs mb-1">Reported</p>
                <p class="text-xl font-bold text-danger">{{ $counts['reported'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-3xl shadow-card p-5">
            <h2 class="font-bold text-sm mb-4">Review Distribution</h2>
            <div class="space-y-2.5">
                @foreach ($distribution as $star => $pct)
                    <div class="flex items-center gap-2 text-xs">
                        <span class="w-8 text-black/50">{{ $star }} ★</span>
                        <div class="flex-1 h-2 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-primary-dark rounded-full" style="width:{{ $pct }}%"></div></div>
                        <span class="w-8 text-right text-black/50">{{ $pct }}%</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex gap-2 overflow-x-auto -mx-4 px-4 md:mx-0 md:px-0 mb-5">
        @foreach (['all' => 'All Reviews', 'pending' => 'Pending', 'approved' => 'Approved', 'reported' => 'Reported'] as $key => $label)
            <a href="{{ route('admin.catalog.reviews.index', array_filter(request()->except('tab', 'page') + ['tab' => $key])) }}"
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
                <label for="reviewSearch" class="sr-only">Search reviews</label>
                <input id="reviewSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search by product or customer..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="rating" aria-label="Filter by rating" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Ratings</option>
                    <option value="5" @selected(request('rating') === '5')>5 Stars</option>
                    <option value="4" @selected(request('rating') === '4')>4 Stars</option>
                    <option value="3-" @selected(request('rating') === '3-')>3 Stars &amp; Below</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <div class="relative">
                <select name="product" aria-label="Filter by product" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Products</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected(request('product') == $product->id)>{{ $product->name }}</option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[940px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 pl-5 font-medium">Customer</th>
                        <th class="py-3 font-medium">Product</th>
                        <th class="py-3 font-medium">Rating</th>
                        <th class="py-3 font-medium">Review</th>
                        <th class="py-3 font-medium">Photo</th>
                        <th class="py-3 font-medium">Date</th>
                        <th class="py-3 font-medium">Status</th>
                        <th class="py-3 pr-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($reviews as $review)
                        @php
                            $statusColor = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'black/50', 'reported' => 'danger'][$review->status];
                        @endphp
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3 pl-5">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-8 h-8 rounded-full bg-primary/20 grid place-items-center text-xs font-semibold shrink-0">{{ strtoupper(substr($review->customer_name, 0, 1)) }}</span>
                                    <span class="font-medium">{{ $review->customer_name }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-black/60">{{ $review->product->name ?? 'Deleted product' }}</td>
                            <td class="py-3 text-primary-dark">{{ str_repeat('★', $review->rating) }}<span class="text-black/20">{{ str_repeat('★', 5 - $review->rating) }}</span></td>
                            <td class="py-3 text-black/60 max-w-[220px] truncate">{{ $review->body ? '"'.$review->body.'"' : '—' }}</td>
                            <td class="py-3">
                                @if ($review->photo_url)
                                    <a href="{{ $review->photo_url }}" target="_blank" rel="noopener" class="block w-10 h-10 rounded-lg overflow-hidden border border-black/10">
                                        <img src="{{ $review->photo_url }}" alt="Review photo" class="w-full h-full object-cover">
                                    </a>
                                @else
                                    <span class="text-black/25">—</span>
                                @endif
                            </td>
                            <td class="py-3 text-black/50 text-xs">{{ $review->created_at->format('M d, Y') }}</td>
                            <td class="py-3">
                                @if ($review->status === 'rejected')
                                    <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">Rejected</span>
                                @else
                                    <span class="bg-{{ $statusColor }}/10 text-{{ $statusColor }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($review->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 pr-5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    @if ($review->status !== 'approved')
                                        <form method="POST" action="{{ route('admin.catalog.reviews.status', $review) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" aria-label="Approve" class="w-8 h-8 rounded-full grid place-items-center hover:bg-success/10 transition"><i class="fa-solid fa-check text-success"></i></button>
                                        </form>
                                    @endif
                                    @if ($review->status !== 'rejected')
                                        <form method="POST" action="{{ route('admin.catalog.reviews.status', $review) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" aria-label="Reject" class="w-8 h-8 rounded-full grid place-items-center hover:bg-danger/10 transition"><i class="fa-solid fa-xmark text-danger"></i></button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.catalog.reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" aria-label="Delete" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-trash-can text-black/40"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="py-10 text-center text-black/40 text-sm">No reviews here.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($reviews->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $reviews->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

@endsection
