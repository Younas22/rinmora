@extends('admin.catalog.layouts.app')

@section('title', 'All Customers')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">All Customers</h1>
            <p class="text-black/45 text-sm mt-1">View profiles, order history, and lifetime value.</p>
        </div>
        <a href="{{ route('admin.customers.create') }}" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
            <i class="fa-solid fa-plus text-[10px]"></i> Add Customer
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Customers</p>
            <p class="text-xl font-bold">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">New This Month</p>
            <p class="text-xl font-bold text-success">{{ $stats['new_this_month'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Returning Customers</p>
            <p class="text-xl font-bold text-info">{{ $stats['returning_pct'] }}%</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Avg. Lifetime Value</p>
            <p class="text-xl font-bold">${{ number_format($stats['avg_lifetime_value'], 2) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <label for="customerSearch" class="sr-only">Search customers</label>
                <input id="customerSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search by name or email..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="tag" aria-label="Filter by tag" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Tags</option>
                    <option value="vip" @selected(request('tag') === 'vip')>VIP</option>
                    <option value="newsletter" @selected(request('tag') === 'newsletter')>Newsletter</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <div class="relative">
                <select name="status" aria-label="Filter by status" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Status</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <div class="relative">
                <select name="sort" aria-label="Sort by" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Sort: Newest</option>
                    <option value="lifetime_value" @selected(request('sort') === 'lifetime_value')>Lifetime Value</option>
                    <option value="most_orders" @selected(request('sort') === 'most_orders')>Most Orders</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[880px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 pl-5 font-medium">Customer</th>
                        <th class="py-3 font-medium">Location</th>
                        <th class="py-3 font-medium">Orders</th>
                        <th class="py-3 font-medium">Lifetime Value</th>
                        <th class="py-3 font-medium">Tags</th>
                        <th class="py-3 font-medium">Status</th>
                        <th class="py-3 font-medium">Last Login</th>
                        <th class="py-3 pr-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3 pl-5">
                                <div class="flex items-center gap-3">
                                    <span class="w-9 h-9 rounded-full bg-primary/20 grid place-items-center text-xs font-semibold shrink-0">{{ strtoupper(substr($customer->first_name, 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <p class="font-semibold truncate">{{ $customer->full_name }}</p>
                                        <p class="text-black/40 text-xs truncate">{{ $customer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-black/60">{{ $customer->city ? $customer->city.', '.$customer->country : '—' }}</td>
                            <td class="py-3 text-black/60">{{ $customer->orders_count }}</td>
                            <td class="py-3 font-semibold">${{ number_format($customer->lifetime_value ?? 0, 2) }}</td>
                            <td class="py-3">
                                <div class="flex flex-wrap gap-1">
                                    @if ($customer->status === 'vip')
                                        <span class="bg-ink text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">VIP</span>
                                    @endif
                                    @if ($customer->marketing_emails)
                                        <span class="bg-info/10 text-info text-[10px] font-semibold px-2 py-0.5 rounded-full">Newsletter</span>
                                    @endif
                                    @if ($customer->status !== 'vip' && !$customer->marketing_emails)
                                        <span class="text-black/30">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3">
                                @if ($customer->status === 'inactive')
                                    <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">Inactive</span>
                                @else
                                    <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Active</span>
                                @endif
                            </td>
                            <td class="py-3 text-black/50 text-xs">{{ $customer->last_login_label }}</td>
                            <td class="py-3 pr-5 text-right">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">View</a>
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">Edit</a>
                                <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="inline" onsubmit="return confirm('Delete this customer?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-danger hover:text-danger/70 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="py-10 text-center text-black/40 text-sm">No customers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($customers->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $customers->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

@endsection
