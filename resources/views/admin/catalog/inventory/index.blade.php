@extends('admin.catalog.layouts.app')

@section('title', 'Inventory')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Inventory</h1>
            <p class="text-black/45 text-sm mt-1">Track and adjust stock levels across your catalog.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Stock</p>
            <p class="text-xl font-bold">{{ number_format($stats['total_stock']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Inventory Value</p>
            <p class="text-xl font-bold">{{ format_price($stats['inventory_value']) }}</p>
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
                <label for="invSearch" class="sr-only">Search inventory</label>
                <input id="invSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search by product or SKU..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
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
            <table class="w-full text-sm min-w-[860px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 pl-5 font-medium">Product</th>
                        <th class="py-3 font-medium">Warehouse</th>
                        <th class="py-3 font-medium text-right">Current</th>
                        <th class="py-3 font-medium text-right">Reserved</th>
                        <th class="py-3 font-medium text-right">Stock Value</th>
                        <th class="py-3 font-medium">Status</th>
                        <th class="py-3 pr-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($products as $product)
                        @php
                            $statusColor = ['In Stock' => 'success', 'Low Stock' => 'warning', 'Out of Stock' => 'danger'][$product->stock_status];
                            $stockValue = $product->quantity * (float) ($product->cost_per_item ?? 0);
                        @endphp
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3 pl-5">
                                <div class="flex items-center gap-3">
                                    @if ($product->coverImage)
                                        <img src="{{ $product->coverImage->thumb_url }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <span class="w-10 h-10 rounded-lg bg-black/5 grid place-items-center text-black/25"><i class="fa-solid fa-image text-xs"></i></span>
                                    @endif
                                    <div><p class="font-semibold">{{ $product->name }}</p><p class="text-black/40 text-xs">SKU: {{ $product->sku ?: '—' }}</p></div>
                                </div>
                            </td>
                            <td class="py-3 text-black/60">Main Warehouse</td>
                            <td class="py-3 text-right font-semibold text-{{ $statusColor }}">{{ $product->quantity }}</td>
                            <td class="py-3 text-right text-black/30">—</td>
                            <td class="py-3 text-right font-semibold">{{ format_price($stockValue) }}</td>
                            <td class="py-3"><span class="bg-{{ $statusColor }}/10 text-{{ $statusColor }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $product->stock_status }}</span></td>
                            <td class="py-3 pr-5 text-right">
                                <button type="button" class="adjust-stock-btn text-xs font-semibold border border-black/10 rounded-full px-3.5 py-1.5 hover:bg-black/5 transition"
                                    data-product-name="{{ $product->name }}"
                                    data-action="{{ route('admin.catalog.inventory.adjust', $product) }}">Adjust</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-10 text-center text-black/40 text-sm">No products yet.</td></tr>
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

    <!-- Stock Adjustment Modal -->
    <div id="adjustModal" class="hidden fixed inset-0 z-50 bg-black/40 grid place-items-center p-4">
        <form method="POST" id="adjustForm" class="w-full max-w-md bg-white rounded-3xl shadow-soft p-6">
            @csrf
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-base">Adjust Stock — <span id="adjustProductName">Product</span></h2>
                <button type="button" onclick="closeAdjustModal()" aria-label="Close" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-black/50 mb-2">Adjustment Type</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="adj-type-label"><input type="radio" name="type" value="add" class="peer sr-only" checked><span class="block text-center bg-ink text-white peer-checked:bg-ink peer-[:not(:checked)]:bg-transparent peer-[:not(:checked)]:text-ink peer-[:not(:checked)]:border peer-[:not(:checked)]:border-black/10 text-xs font-semibold py-2.5 rounded-xl transition cursor-pointer">Add</span></label>
                        <label class="adj-type-label"><input type="radio" name="type" value="remove" class="peer sr-only"><span class="block text-center border border-black/10 peer-checked:bg-ink peer-checked:text-white peer-checked:border-transparent text-xs font-semibold py-2.5 rounded-xl transition cursor-pointer hover:bg-black/5">Remove</span></label>
                        <label class="adj-type-label"><input type="radio" name="type" value="set" class="peer sr-only"><span class="block text-center border border-black/10 peer-checked:bg-ink peer-checked:text-white peer-checked:border-transparent text-xs font-semibold py-2.5 rounded-xl transition cursor-pointer hover:bg-black/5">Set To</span></label>
                    </div>
                </div>
                <div>
                    <label for="adjQty" class="block text-xs font-medium text-black/50 mb-2">Quantity</label>
                    <input id="adjQty" name="quantity" type="number" min="0" value="10" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label for="adjReason" class="block text-xs font-medium text-black/50 mb-2">Reason</label>
                    <select id="adjReason" name="reason" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary cursor-pointer">
                        <option value="restock">Restock / New Shipment</option>
                        <option value="damaged">Damaged / Written Off</option>
                        <option value="recount">Inventory Recount</option>
                        <option value="return_to_stock">Return to Stock</option>
                    </select>
                </div>
                <div>
                    <label for="adjNotes" class="block text-xs font-medium text-black/50 mb-2">Notes <span class="text-black/30">(Optional)</span></label>
                    <textarea id="adjNotes" name="notes" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary resize-none"></textarea>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="button" onclick="closeAdjustModal()" class="flex-1 border border-black/10 rounded-full py-2.5 text-xs font-semibold hover:bg-black/5 transition">Cancel</button>
                <button type="submit" class="flex-1 bg-primary text-ink rounded-full py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Adjustment</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
  function openAdjustModal(name, action) {
    document.getElementById('adjustProductName').textContent = name;
    document.getElementById('adjustForm').action = action;
    document.getElementById('adjustModal').classList.remove('hidden');
  }
  function closeAdjustModal() { document.getElementById('adjustModal').classList.add('hidden'); }
  document.querySelectorAll('.adjust-stock-btn').forEach(btn => {
    btn.addEventListener('click', () => openAdjustModal(btn.dataset.productName, btn.dataset.action));
  });
</script>
@endpush
