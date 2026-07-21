@php
    $reasonLabels = ['restock' => 'Restock', 'damaged' => 'Damaged', 'recount' => 'Recount', 'return_to_stock' => 'Returned to Stock', 'order_placed' => 'Order Placed', 'order_cancelled' => 'Order Cancelled'];
    $reasonTotal = max(1, $byReason->sum('total'));
@endphp

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-cubes text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ number_format($inventoryKpis['total_stock']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Total Stock (Units)</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-warehouse text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ format_price($inventoryKpis['inventory_value']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Inventory Value</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-warning/10 grid place-items-center mb-3"><i class="fa-solid fa-triangle-exclamation text-warning text-xs"></i></span>
        <p class="text-xl font-bold">{{ number_format($inventoryKpis['low_stock']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Low Stock</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-danger/10 grid place-items-center mb-3"><i class="fa-solid fa-ban text-danger text-xs"></i></span>
        <p class="text-xl font-bold">{{ number_format($inventoryKpis['out_of_stock']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Out of Stock</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-5 mb-6">
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-5">Stock Movement Activity</h2>
        <div class="flex items-end gap-4 h-40">
            @foreach ($movementTrend as $w)
                @php $pct = round($w['count'] / $maxMovements * 100); @endphp
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-black/5 rounded-lg overflow-hidden flex items-end h-32">
                        <div class="w-full bg-primary-dark rounded-t-lg" style="height:{{ max(4, $pct) }}%"></div>
                    </div>
                    <span class="text-[10px] text-black/40">{{ $w['label'] }}</span>
                    <span class="text-xs font-semibold">{{ $w['count'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-4">Movements by Reason</h2>
        @if ($byReason->isEmpty())
            <p class="text-black/40 text-xs">No stock movements this period.</p>
        @else
            <ul class="space-y-2.5">
                @foreach ($byReason as $row)
                    @php $pct = round($row->total / $reasonTotal * 100); @endphp
                    <li>
                        <div class="flex items-center justify-between text-xs mb-1"><span class="text-black/70">{{ $reasonLabels[$row->reason] ?? ucfirst($row->reason) }}</span><span class="text-black/40">{{ $row->total }} units</span></div>
                        <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-primary-dark rounded-full" style="width:{{ $pct }}%"></div></div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
    <h2 class="font-bold text-sm mb-1">Top Shrinkage</h2>
    <p class="text-black/40 text-xs mb-5">Products with the most units marked "Damaged" this period.</p>
    <table class="w-full text-sm min-w-[420px]">
        <thead>
            <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                <th class="py-3 font-medium">Product</th>
                <th class="py-3 font-medium text-right">Units Damaged</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($topShrinkage as $row)
                <tr class="hover:bg-black/[0.02] transition">
                    <td class="py-3">{{ $row->name }}</td>
                    <td class="py-3 text-right text-danger font-medium">{{ $row->total }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="py-10 text-center text-black/40 text-sm">No damaged-stock movements this period.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
