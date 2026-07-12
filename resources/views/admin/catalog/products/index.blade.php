@extends('admin.catalog.layouts.app')

@section('title', 'All Products')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">All Products</h1>
            <p class="text-black/45 text-sm mt-1">Manage your catalog, pricing, and inventory.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.catalog.products.create') }}" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                <i class="fa-solid fa-plus text-[10px]"></i> Add Product
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Products</p>
            <p class="text-xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">In Stock</p>
            <p class="text-xl font-bold text-success">{{ $stats['in_stock'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Low Stock</p>
            <p class="text-xl font-bold text-warning">{{ $stats['low_stock'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Out of Stock</p>
            <p class="text-xl font-bold text-danger">{{ $stats['out_of_stock'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <label for="productSearch" class="sr-only">Search products</label>
                <input id="productSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search products or SKU..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
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
                <select name="brand" aria-label="Filter by brand" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Brands</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(request('brand') == $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <div class="relative">
                <select name="status" aria-label="Filter by status" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Status</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <div class="relative">
                <select name="stock" aria-label="Filter by stock status" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Stock</option>
                    <option value="in_stock" @selected(request('stock') === 'in_stock')>In Stock</option>
                    <option value="low_stock" @selected(request('stock') === 'low_stock')>Low Stock</option>
                    <option value="out_of_stock" @selected(request('stock') === 'out_of_stock')>Out of Stock</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[880px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 pl-5 font-medium">Product</th>
                        <th class="py-3 font-medium">Category</th>
                        <th class="py-3 font-medium">Price</th>
                        <th class="py-3 font-medium">Stock</th>
                        <th class="py-3 font-medium">Status</th>
                        <th class="py-3 font-medium text-center">Featured</th>
                        <th class="py-3 pr-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($products as $product)
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3 pl-5 pr-4">
                                <div class="flex items-center gap-3">
                                    @if ($product->coverImage)
                                        <img src="{{ $product->coverImage->thumb_url }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover shrink-0">
                                    @else
                                        <span class="w-10 h-10 rounded-lg bg-black/5 grid place-items-center text-black/25 shrink-0"><i class="fa-solid fa-image text-xs"></i></span>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-semibold truncate">{{ $product->name }}</p>
                                        <p class="text-black/40 text-xs">SKU: {{ $product->sku ?: '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-black/60">{{ $product->category->name ?? '—' }}</td>
                            <td class="py-3 font-semibold">{{ format_price($product->price) }}</td>
                            <td class="py-3">
                                @php $statusColor = ['In Stock' => 'success', 'Low Stock' => 'warning', 'Out of Stock' => 'danger'][$product->stock_status]; @endphp
                                <span class="text-{{ $statusColor }} font-medium">{{ $product->quantity }} in stock</span>
                            </td>
                            <td class="py-3">
                                @php $badge = ['active' => 'success', 'draft' => 'black/50', 'archived' => 'danger'][$product->status]; @endphp
                                @if ($product->status === 'draft')
                                    <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">Draft</span>
                                @else
                                    <span class="bg-{{ $badge }}/10 text-{{ $badge }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($product->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <form method="POST" action="{{ route('admin.catalog.products.update', $product) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="toggle_featured_only" value="1">
                                    <input type="hidden" name="is_featured" value="{{ $product->is_featured ? 0 : 1 }}">
                                    <button type="submit" aria-label="Toggle featured" class="{{ $product->is_featured ? 'text-primary-dark' : 'text-black/20' }}">
                                        <i class="fa-{{ $product->is_featured ? 'solid' : 'regular' }} fa-star"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 pr-5 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('admin.catalog.products.edit', $product) }}" class="text-xs font-semibold text-black/50 hover:bg-black/5 hover:text-ink px-3 py-1.5 rounded-full transition">Edit</a>
                                    <form method="POST" action="{{ route('admin.catalog.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete this product? This cannot be undone.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" aria-label="Delete {{ $product->name }}" class="w-8 h-8 rounded-full grid place-items-center text-black/30 hover:bg-danger/10 hover:text-danger transition">
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-black/40 text-sm">No products yet — add your first one.</td>
                        </tr>
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
