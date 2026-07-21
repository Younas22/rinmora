<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center"><i class="fa-solid fa-user-plus text-primary-dark text-xs"></i></span>
            <span class="text-[11px] font-semibold {{ $customerKpis['new_customers']['change'] >= 0 ? 'text-success bg-success/10' : 'text-danger bg-danger/10' }} px-2 py-1 rounded-full"><i class="fa-solid {{ $customerKpis['new_customers']['change'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[9px] mr-0.5"></i>{{ abs($customerKpis['new_customers']['change']) }}%</span>
        </div>
        <p class="text-xl font-bold">{{ number_format($customerKpis['new_customers']['value']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">New Customers &middot; vs last period</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-users text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ number_format($customerKpis['total_customers']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Total Customers</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-rotate text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ $customerKpis['repeat_rate'] }}%</p>
        <p class="text-black/45 text-xs mt-0.5">Repeat Rate (Buyers This Period)</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-crown text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ format_price($customerKpis['avg_lifetime_value']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Avg. Lifetime Value</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-5 mb-6">
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-5">New Signups</h2>
        <div class="flex items-end gap-4 h-40">
            @foreach ($signupTrend as $w)
                @php $pct = round($w['count'] / $maxSignups * 100); @endphp
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
        <h2 class="font-bold text-sm mb-4">Customer Tiers</h2>
        @php $tierTotal = max(1, $tierBreakdown->sum('total')); @endphp
        <ul class="space-y-2.5">
            @forelse ($tierBreakdown as $tier)
                @php $pct = round($tier->total / $tierTotal * 100); @endphp
                <li>
                    <div class="flex items-center justify-between text-xs mb-1"><span class="text-black/70 capitalize">{{ $tier->customer_tier }}</span><span class="text-black/40">{{ $tier->total }}</span></div>
                    <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-primary-dark rounded-full" style="width:{{ $pct }}%"></div></div>
                </li>
            @empty
                <li class="text-black/40 text-xs">No customers yet.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
    <h2 class="font-bold text-sm mb-5">Top Customers This Period</h2>
    <table class="w-full text-sm min-w-[480px]">
        <thead>
            <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                <th class="py-3 font-medium">Customer</th>
                <th class="py-3 font-medium text-right">Orders</th>
                <th class="py-3 font-medium text-right">Spend</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($topCustomers as $c)
                <tr class="hover:bg-black/[0.02] transition">
                    <td class="py-3">{{ $c->user->full_name ?? 'Unknown' }}</td>
                    <td class="py-3 text-right">{{ $c->orders_count }}</td>
                    <td class="py-3 text-right font-medium">{{ format_price($c->spend) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="py-10 text-center text-black/40 text-sm">No orders this period.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
