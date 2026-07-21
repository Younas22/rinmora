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

    @php $builtReportTypes = ['sales', 'products', 'customers', 'orders', 'revenue', 'inventory']; @endphp

    @if (!in_array($reportType, $builtReportTypes))
        <div class="bg-white rounded-3xl shadow-card p-12 text-center">
            <i class="fa-solid fa-chart-simple text-black/15 text-3xl mb-3"></i>
            <p class="text-black/50 text-sm font-semibold">{{ $reportTypes[$reportType] }} report isn't built yet</p>
            <p class="text-black/35 text-xs mt-1">
                @if ($reportType === 'coupons')
                    There's no coupon/discount-code system in the store yet — nothing real to report on.
                @else
                    Only the Sales, Products, Customers, Orders, Revenue, and Inventory reports have real data in this pass.
                @endif
            </p>
        </div>
    @else
        @include('admin.system.reports.partials.'.$reportType)
    @endif

@endsection
