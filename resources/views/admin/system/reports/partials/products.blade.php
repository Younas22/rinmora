<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-box text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ number_format($productKpis['units_sold']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Units Sold This Period</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-boxes-stacked text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ number_format($productKpis['active_products']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Active Products</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-star text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ $productKpis['avg_rating'] > 0 ? $productKpis['avg_rating'] : '—' }}</p>
        <p class="text-black/45 text-xs mt-0.5">Avg. Rating (Approved Reviews)</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-warning/10 grid place-items-center mb-3"><i class="fa-solid fa-triangle-exclamation text-warning text-xs"></i></span>
        <p class="text-xl font-bold">{{ number_format($productKpis['low_stock']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Low Stock Products</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-5 mb-6">
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
        <h2 class="font-bold text-sm mb-5">Top Sellers</h2>
        <table class="w-full text-sm min-w-[420px]">
            <thead>
                <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                    <th class="py-2 font-medium">Product</th>
                    <th class="py-2 font-medium text-right">Units Sold</th>
                    <th class="py-2 font-medium text-right">Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($topSellers as $p)
                    <tr class="hover:bg-black/[0.02] transition">
                        <td class="py-2.5 text-black/70 truncate max-w-[220px]">{{ $p->product_name }}</td>
                        <td class="py-2.5 text-right font-medium">{{ $p->sold }}</td>
                        <td class="py-2.5 text-right">{{ format_price($p->revenue) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-8 text-center text-black/40 text-sm">No sales this period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-4">Revenue by Category</h2>
        <ul class="space-y-2.5">
            @forelse ($revenueByCategory as $cat)
                @php $pct = round($cat->total / $categoryTotal * 100); @endphp
                <li>
                    <div class="flex items-center justify-between text-xs mb-1"><span class="text-black/70">{{ $cat->name }}</span><span class="text-black/40">{{ $cat->units }} units</span></div>
                    <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-primary-dark rounded-full" style="width:{{ $pct }}%"></div></div>
                </li>
            @empty
                <li class="text-black/40 text-xs">No data yet.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
    <h2 class="font-bold text-sm mb-1">Never Sold</h2>
    <p class="text-black/40 text-xs mb-5">Active products with zero orders, ever — candidates for a promo push or a re-check on merchandising.</p>
    <table class="w-full text-sm min-w-[480px]">
        <thead>
            <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                <th class="py-3 font-medium">Product</th>
                <th class="py-3 font-medium text-right">Stock</th>
                <th class="py-3 font-medium text-right">Price</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($neverSold as $p)
                <tr class="hover:bg-black/[0.02] transition">
                    <td class="py-3">{{ $p->name }}</td>
                    <td class="py-3 text-right">{{ $p->quantity }}</td>
                    <td class="py-3 text-right">{{ format_price($p->price) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="py-10 text-center text-black/40 text-sm">Every active product has sold at least once.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
