@php
    $statusColors = ['delivered' => 'success', 'shipped' => 'info', 'processing' => 'warning', 'packed' => 'warning', 'cancelled' => 'black/50', 'returned' => 'black/50', 'refunded' => 'danger', 'pending' => 'black/50'];
    $paymentColors = ['paid' => 'success', 'refunded' => 'danger', 'pending' => 'warning'];
    $statusTotal = max(1, $statusBreakdown->sum('total'));
    $paymentTotal = max(1, $paymentBreakdown->sum('total'));
@endphp

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-receipt text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ number_format($orderKpis['total_orders']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Total Orders</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-success/10 grid place-items-center mb-3"><i class="fa-solid fa-box-open text-success text-xs"></i></span>
        <p class="text-xl font-bold">{{ number_format($orderKpis['delivered']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Delivered</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-danger/10 grid place-items-center mb-3"><i class="fa-solid fa-ban text-danger text-xs"></i></span>
        <p class="text-xl font-bold">{{ $orderKpis['cancelled_rate'] }}%</p>
        <p class="text-black/45 text-xs mt-0.5">Cancellation Rate</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-basket-shopping text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ $orderKpis['avg_items'] }}</p>
        <p class="text-black/45 text-xs mt-0.5">Avg. Items per Order</p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-5 mb-6">
    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-4">Order Status Breakdown</h2>
        <ul class="space-y-2.5">
            @forelse ($statusBreakdown as $row)
                @php $pct = round($row->total / $statusTotal * 100); @endphp
                <li>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="capitalize"><span class="inline-block w-2 h-2 rounded-full bg-{{ $statusColors[$row->status] ?? 'black/50' }} mr-1.5"></span>{{ $row->status }}</span>
                        <span class="text-black/40">{{ $row->total }} ({{ $pct }}%)</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-{{ $statusColors[$row->status] ?? 'black/50' }} rounded-full" style="width:{{ $pct }}%"></div></div>
                </li>
            @empty
                <li class="text-black/40 text-xs">No orders this period.</li>
            @endforelse
        </ul>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-4">Payment Status Breakdown</h2>
        <ul class="space-y-2.5">
            @forelse ($paymentBreakdown as $row)
                @php $pct = round($row->total / $paymentTotal * 100); @endphp
                <li>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="capitalize"><span class="inline-block w-2 h-2 rounded-full bg-{{ $paymentColors[$row->payment_status] ?? 'black/50' }} mr-1.5"></span>{{ $row->payment_status }}</span>
                        <span class="text-black/40">{{ $row->total }} ({{ $pct }}%)</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-{{ $paymentColors[$row->payment_status] ?? 'black/50' }} rounded-full" style="width:{{ $pct }}%"></div></div>
                </li>
            @empty
                <li class="text-black/40 text-xs">No orders this period.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
    <h2 class="font-bold text-sm mb-5">Daily Order Activity</h2>
    <table class="w-full text-sm min-w-[480px]">
        <thead>
            <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                <th class="py-3 font-medium">Date</th>
                <th class="py-3 font-medium text-right">Total Orders</th>
                <th class="py-3 font-medium text-right">Delivered</th>
                <th class="py-3 font-medium text-right">Cancelled</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($dailyOrders as $day)
                <tr class="hover:bg-black/[0.02] transition">
                    <td class="py-3">{{ \Illuminate\Support\Carbon::parse($day->day)->format('M d, Y') }}</td>
                    <td class="py-3 text-right font-medium">{{ $day->total }}</td>
                    <td class="py-3 text-right text-success">{{ $day->delivered }}</td>
                    <td class="py-3 text-right {{ $day->cancelled > 0 ? 'text-danger' : 'text-black/40' }}">{{ $day->cancelled }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-10 text-center text-black/40 text-sm">No orders this period.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
