@extends('admin.catalog.layouts.app')

@section('title', 'Reports')

@section('content')

    @php
        $reportTypes = ['sales' => 'Sales', 'products' => 'Products', 'customers' => 'Customers', 'orders' => 'Orders', 'revenue' => 'Revenue', 'inventory' => 'Inventory', 'coupons' => 'Coupons'];
        $dateRanges = ['this_month' => 'This Month', 'last_month' => 'Last Month', 'last_7_days' => 'Last 7 Days', 'last_30_days' => 'Last 30 Days', 'this_year' => 'This Year', 'custom' => 'Custom Range'];
        $exportParams = array_filter(['range' => $dateRange, 'from' => request('from'), 'to' => request('to')]);
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Reports</h1>
            <p class="text-black/45 text-sm mt-1">{{ $start->format('M j') }} &ndash; {{ $end->format('M j, Y') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.system.reports.sales.export', $exportParams) }}" class="inline-flex items-center gap-2 bg-white border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">
                <i class="fa-solid fa-file-csv text-black/40"></i> Export CSV
            </a>
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 bg-white border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">
                <i class="fa-solid fa-print text-black/40"></i> Print
            </button>
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div class="flex flex-wrap items-center gap-1 bg-white rounded-full shadow-card p-1.5 overflow-x-auto">
            @foreach ($reportTypes as $key => $label)
                <a href="{{ route('admin.system.reports.index', ['type' => $key] + $exportParams) }}" class="px-5 py-2 rounded-full text-xs font-semibold whitespace-nowrap transition {{ $reportType === $key ? 'bg-primary/20 text-ink' : 'text-black/50 hover:text-ink' }}">{{ $label }}</a>
            @endforeach
        </div>

        <form method="GET" class="flex items-center gap-2" id="dateRangeForm">
            <input type="hidden" name="type" value="{{ $reportType }}">
            <div class="relative">
                <select name="range" id="dateRangeSelect" onchange="document.getElementById('customRangeFields').classList.toggle('hidden', this.value !== 'custom'); if (this.value !== 'custom') this.form.submit();" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    @foreach ($dateRanges as $key => $label)
                        <option value="{{ $key }}" @selected($dateRange === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <div id="customRangeFields" class="flex items-center gap-2 {{ $dateRange === 'custom' ? '' : 'hidden' }}">
                <input type="date" name="from" value="{{ request('from', $dateRange === 'custom' ? $start->format('Y-m-d') : '') }}" class="border border-black/10 rounded-full px-3 py-2.5 text-xs font-medium bg-white focus:outline-none focus:ring-2 focus:ring-primary">
                <span class="text-black/30 text-xs">&ndash;</span>
                <input type="date" name="to" value="{{ request('to', $dateRange === 'custom' ? $end->format('Y-m-d') : '') }}" class="border border-black/10 rounded-full px-3 py-2.5 text-xs font-medium bg-white focus:outline-none focus:ring-2 focus:ring-primary">
                <button type="submit" class="bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Apply</button>
            </div>
        </form>
    </div>

    @if ($reportType !== 'sales')
        <div class="bg-white rounded-3xl shadow-card p-12 text-center">
            <i class="fa-solid fa-chart-simple text-black/15 text-3xl mb-3"></i>
            <p class="text-black/50 text-sm font-semibold">{{ $reportTypes[$reportType] }} report isn't built yet</p>
            <p class="text-black/35 text-xs mt-1">Only the Sales report has real data in this pass.</p>
        </div>
    @else

        <!-- KPI Row -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
            <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center"><i class="fa-solid fa-sack-dollar text-primary-dark text-xs"></i></span>
                    <span class="text-[11px] font-semibold {{ $kpis['revenue']['change'] >= 0 ? 'text-success bg-success/10' : 'text-danger bg-danger/10' }} px-2 py-1 rounded-full"><i class="fa-solid {{ $kpis['revenue']['change'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[9px] mr-0.5"></i>{{ abs($kpis['revenue']['change']) }}%</span>
                </div>
                <p class="text-xl font-bold">{{ format_price($kpis['revenue']['value']) }}</p>
                <p class="text-black/45 text-xs mt-0.5">Total Revenue &middot; vs {{ format_price($kpis['revenue']['prev']) }} last period</p>
            </div>
            <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center"><i class="fa-solid fa-receipt text-primary-dark text-xs"></i></span>
                    <span class="text-[11px] font-semibold {{ $kpis['orders']['change'] >= 0 ? 'text-success bg-success/10' : 'text-danger bg-danger/10' }} px-2 py-1 rounded-full"><i class="fa-solid {{ $kpis['orders']['change'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[9px] mr-0.5"></i>{{ abs($kpis['orders']['change']) }}%</span>
                </div>
                <p class="text-xl font-bold">{{ number_format($kpis['orders']['value']) }}</p>
                <p class="text-black/45 text-xs mt-0.5">Total Orders &middot; vs {{ number_format($kpis['orders']['prev']) }} last period</p>
            </div>
            <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center"><i class="fa-solid fa-scale-balanced text-primary-dark text-xs"></i></span>
                    <span class="text-[11px] font-semibold {{ $kpis['aov']['change'] >= 0 ? 'text-success bg-success/10' : 'text-danger bg-danger/10' }} px-2 py-1 rounded-full"><i class="fa-solid {{ $kpis['aov']['change'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[9px] mr-0.5"></i>{{ abs($kpis['aov']['change']) }}%</span>
                </div>
                <p class="text-xl font-bold">{{ format_price($kpis['aov']['value']) }}</p>
                <p class="text-black/45 text-xs mt-0.5">Avg. Order Value &middot; vs {{ format_price($kpis['aov']['prev']) }} last period</p>
            </div>
            <div class="hover-lift bg-white rounded-2xl shadow-card p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-9 h-9 rounded-full bg-danger/10 grid place-items-center"><i class="fa-solid fa-rotate-left text-danger text-xs"></i></span>
                    <span class="text-[11px] font-semibold {{ $kpis['refund_rate']['change'] <= 0 ? 'text-success bg-success/10' : 'text-danger bg-danger/10' }} px-2 py-1 rounded-full"><i class="fa-solid {{ $kpis['refund_rate']['change'] <= 0 ? 'fa-arrow-down' : 'fa-arrow-up' }} text-[9px] mr-0.5"></i>{{ abs($kpis['refund_rate']['change']) }}pt</span>
                </div>
                <p class="text-xl font-bold">{{ $kpis['refund_rate']['value'] }}%</p>
                <p class="text-black/45 text-xs mt-0.5">Refund Rate &middot; vs {{ $kpis['refund_rate']['prev'] }}% last period</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-5 mb-6">
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-5">Weekly Order Volume</h2>
                <div class="flex items-end gap-4 h-40">
                    @foreach ($weeklyVolume as $w)
                        @php $pct = round($w['count'] / $maxWeekly * 100); @endphp
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
                <h2 class="font-bold text-sm mb-4">Revenue by Category</h2>
                @if ($revenueByCategory->isEmpty())
                    <p class="text-black/40 text-xs">No category revenue yet.</p>
                @else
                    @php
                        $donutColors = ['#CFBAA5', '#000000', '#3B82F6', '#F59E0B'];
                        $gradientParts = [];
                        $cursor = 0;
                        foreach ($revenueByCategory as $i => $cat) {
                            $slice = round($cat->total / $categoryTotal * 360);
                            $gradientParts[] = ($donutColors[$i % 4]) . ' ' . $cursor . 'deg ' . ($cursor + $slice) . 'deg';
                            $cursor += $slice;
                        }
                    @endphp
                    <div class="w-32 h-32 rounded-full mx-auto mb-4" style="background: conic-gradient({{ implode(', ', $gradientParts) }});"></div>
                    <ul class="space-y-1.5 text-xs">
                        @foreach ($revenueByCategory as $i => $cat)
                            <li class="flex items-center justify-between">
                                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full" style="background:{{ $donutColors[$i % 4] }}"></span>{{ $cat->name }}</span>
                                <span class="text-black/40">{{ round($cat->total / $categoryTotal * 100) }}%</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-3xl shadow-card p-5">
                <h2 class="font-bold text-sm mb-4">Top Products</h2>
                <ul class="space-y-3">
                    @forelse ($topProducts as $p)
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-black/70 truncate pr-2">{{ $p->product_name }}</span>
                            <span class="text-black/40 text-xs shrink-0">{{ $p->sold }} sold &middot; {{ format_price($p->revenue) }}</span>
                        </li>
                    @empty
                        <li class="text-black/40 text-xs">No sales this period.</li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-white rounded-3xl shadow-card p-5">
                <h2 class="font-bold text-sm mb-4">Top Customers</h2>
                <ul class="space-y-3">
                    @forelse ($topCustomers as $c)
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-black/70 truncate pr-2">{{ $c->user->full_name ?? 'Unknown' }}</span>
                            <span class="text-black/40 text-xs shrink-0">{{ $c->orders_count }} orders &middot; {{ format_price($c->spend) }}</span>
                        </li>
                    @empty
                        <li class="text-black/40 text-xs">No orders this period.</li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-white rounded-3xl shadow-card p-5">
                <h2 class="font-bold text-sm mb-4">Top Categories</h2>
                <ul class="space-y-2.5">
                    @forelse ($revenueByCategory as $cat)
                        @php $pct = round($cat->total / $categoryTotal * 100); @endphp
                        <li>
                            <div class="flex items-center justify-between text-xs mb-1"><span class="text-black/70">{{ $cat->name }}</span><span class="text-black/40">{{ format_price($cat->total) }}</span></div>
                            <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-primary-dark rounded-full" style="width:{{ $pct }}%"></div></div>
                        </li>
                    @empty
                        <li class="text-black/40 text-xs">No data yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
            <h2 class="font-bold text-sm mb-5">Daily Summary</h2>
            <table class="w-full text-sm min-w-[560px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 font-medium">Date</th>
                        <th class="py-3 font-medium text-right">Orders</th>
                        <th class="py-3 font-medium text-right">Revenue</th>
                        <th class="py-3 font-medium text-right">Refunds</th>
                        <th class="py-3 font-medium text-right">Net</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($dailySummary as $day)
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3">{{ \Illuminate\Support\Carbon::parse($day['date'])->format('M d, Y') }}</td>
                            <td class="py-3 text-right">{{ $day['orders'] }}</td>
                            <td class="py-3 text-right">{{ format_price($day['revenue']) }}</td>
                            <td class="py-3 text-right {{ $day['refunds'] > 0 ? 'text-danger' : 'text-black/40' }}">{{ $day['refunds'] > 0 ? '-$'.number_format($day['refunds'], 0) : '$0' }}</td>
                            <td class="py-3 text-right font-bold">{{ format_price($day['net']) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-10 text-center text-black/40 text-sm">No orders this period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

@endsection
