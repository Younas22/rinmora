<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center"><i class="fa-solid fa-sack-dollar text-primary-dark text-xs"></i></span>
            <span class="text-[11px] font-semibold {{ $revenueKpis['gross']['change'] >= 0 ? 'text-success bg-success/10' : 'text-danger bg-danger/10' }} px-2 py-1 rounded-full"><i class="fa-solid {{ $revenueKpis['gross']['change'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[9px] mr-0.5"></i>{{ abs($revenueKpis['gross']['change']) }}%</span>
        </div>
        <p class="text-xl font-bold">{{ format_price($revenueKpis['gross']['value']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Gross Revenue &middot; vs last period</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center"><i class="fa-solid fa-coins text-primary-dark text-xs"></i></span>
            <span class="text-[11px] font-semibold {{ $revenueKpis['net']['change'] >= 0 ? 'text-success bg-success/10' : 'text-danger bg-danger/10' }} px-2 py-1 rounded-full"><i class="fa-solid {{ $revenueKpis['net']['change'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[9px] mr-0.5"></i>{{ abs($revenueKpis['net']['change']) }}%</span>
        </div>
        <p class="text-xl font-bold">{{ format_price($revenueKpis['net']['value']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Net Revenue (after refunds) &middot; vs last period</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-danger/10 grid place-items-center mb-3"><i class="fa-solid fa-rotate-left text-danger text-xs"></i></span>
        <p class="text-xl font-bold">{{ format_price($revenueKpis['refunds']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Refunds Issued</p>
    </div>
    <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
        <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center mb-3"><i class="fa-solid fa-tags text-primary-dark text-xs"></i></span>
        <p class="text-xl font-bold">{{ format_price($revenueKpis['discounts']) }}</p>
        <p class="text-black/45 text-xs mt-0.5">Discounts Given</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-5 mb-6">
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-5">Revenue Trend (Last 6 Months)</h2>
        <div class="flex items-end gap-3 h-40">
            @foreach ($monthlyTrend as $m)
                @php $pct = round($m['total'] / $maxMonthly * 100); @endphp
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-black/5 rounded-lg overflow-hidden flex items-end h-32">
                        <div class="w-full bg-primary-dark rounded-t-lg" style="height:{{ max(4, $pct) }}%"></div>
                    </div>
                    <span class="text-[10px] text-black/40">{{ $m['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-4">Revenue by Payment Method</h2>
        @if ($byGateway->isEmpty())
            <p class="text-black/40 text-xs">No successful payments this period.</p>
        @else
            <ul class="space-y-2.5">
                @foreach ($byGateway as $g)
                    @php $pct = round($g->total / $gatewayTotal * 100); @endphp
                    <li>
                        <div class="flex items-center justify-between text-xs mb-1"><span class="text-black/70">{{ $g->name }}</span><span class="text-black/40">{{ format_price($g->total) }}</span></div>
                        <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-primary-dark rounded-full" style="width:{{ $pct }}%"></div></div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
    <h2 class="font-bold text-sm mb-5">Revenue Breakdown</h2>
    <div class="space-y-2 text-sm max-w-md">
        <div class="flex justify-between"><span class="text-black/50">Subtotal (items)</span><span>{{ format_price($components['subtotal']) }}</span></div>
        <div class="flex justify-between"><span class="text-black/50">Shipping Collected</span><span>{{ format_price($components['shipping']) }}</span></div>
        <div class="flex justify-between"><span class="text-black/50">Tax Collected</span><span>{{ format_price($components['tax']) }}</span></div>
        <div class="flex justify-between text-danger"><span>Discounts Given</span><span>&minus;{{ format_price($components['discounts']) }}</span></div>
        <div class="flex justify-between text-danger"><span>Refunds Issued</span><span>&minus;{{ format_price($components['refunds']) }}</span></div>
        <div class="flex justify-between text-base font-bold pt-2 border-t border-black/10"><span>Net Revenue</span><span>{{ format_price($components['net']) }}</span></div>
    </div>
</div>
