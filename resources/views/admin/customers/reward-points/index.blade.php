@extends('admin.catalog.layouts.app')

@section('title', 'Reward Points')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Reward Points</h1>
            <p class="text-black/45 text-sm mt-1">Track loyalty point balances and manage the earn &amp; redeem program.</p>
        </div>
        <button type="button" class="inline-flex items-center gap-2 bg-white border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold text-black/40 cursor-not-allowed" title="No program configuration form in this pass" disabled>Program Settings</button>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Points Outstanding</p>
            <p class="text-xl font-bold">{{ number_format($stats['points_outstanding']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Redeemed This Month</p>
            <p class="text-xl font-bold text-success">{{ number_format($stats['redeemed_this_month']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Enrolled Customers</p>
            <p class="text-xl font-bold text-info">{{ $stats['enrolled_customers'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Expiring This Month</p>
            <p class="text-xl font-bold text-warning">{{ number_format($stats['expiring_this_month']) }}</p>
        </div>
    </div>

    <div class="grid sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5 flex items-center gap-3">
            <span class="w-10 h-10 rounded-full bg-primary/20 grid place-items-center shrink-0"><i class="fa-solid fa-coins text-primary-dark"></i></span>
            <div><p class="text-black/45 text-xs">Earn Rate</p><p class="text-sm font-semibold">1 point per $1 spent</p></div>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5 flex items-center gap-3">
            <span class="w-10 h-10 rounded-full bg-primary/20 grid place-items-center shrink-0"><i class="fa-solid fa-gift text-primary-dark"></i></span>
            <div><p class="text-black/45 text-xs">Redemption Rate</p><p class="text-sm font-semibold">100 points = $5 off</p></div>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5 flex items-center gap-3">
            <span class="w-10 h-10 rounded-full bg-primary/20 grid place-items-center shrink-0"><i class="fa-solid fa-hourglass-half text-primary-dark"></i></span>
            <div><p class="text-black/45 text-xs">Points Expire After</p><p class="text-sm font-semibold">12 months of inactivity</p></div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <label for="rewardsSearch" class="sr-only">Search customers</label>
                <input id="rewardsSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search by name or email..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="tier" aria-label="Filter by tier" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Tiers</option>
                    <option value="platinum" @selected(request('tier') === 'platinum')>Platinum</option>
                    <option value="gold" @selected(request('tier') === 'gold')>Gold</option>
                    <option value="silver" @selected(request('tier') === 'silver')>Silver</option>
                    <option value="bronze" @selected(request('tier') === 'bronze')>Bronze</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <div class="relative">
                <select name="sort" aria-label="Sort by" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Sort: Highest Balance</option>
                    <option value="expiring_soon" @selected(request('sort') === 'expiring_soon')>Points Expiring Soon</option>
                    <option value="most_redeemed" @selected(request('sort') === 'most_redeemed')>Most Redeemed</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[720px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 pl-5 font-medium">Customer</th>
                        <th class="py-3 font-medium">Tier</th>
                        <th class="py-3 font-medium">Points Balance</th>
                        <th class="py-3 font-medium">Lifetime Earned</th>
                        <th class="py-3 font-medium">Redeemed</th>
                        <th class="py-3 pr-5 font-medium">Expiring Soon</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($rewardPoints as $rp)
                        @php
                            $tierStyle = [
                                'platinum' => 'bg-black/10 text-black/70',
                                'gold' => 'bg-primary/15 text-primary-dark',
                                'silver' => 'bg-black/5 text-black/50',
                                'bronze' => "bg-[#CD7F32]/15 text-[#8a5320]",
                            ][$rp->user->customer_tier ?? 'bronze'];
                        @endphp
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3 pl-5">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-8 h-8 rounded-full bg-primary/20 grid place-items-center text-xs font-semibold shrink-0">{{ strtoupper(substr($rp->user->first_name ?? '?', 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <p class="font-medium truncate">{{ $rp->user->full_name ?? 'Unknown' }}</p>
                                        <p class="text-black/40 text-xs truncate">{{ $rp->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3"><span class="{{ $tierStyle }} text-[11px] font-semibold px-2.5 py-1 rounded-full capitalize">{{ $rp->user->customer_tier ?? '—' }}</span></td>
                            <td class="py-3 font-semibold">{{ number_format($rp->points_balance) }} pts</td>
                            <td class="py-3 text-black/60">{{ number_format($rp->lifetime_earned) }} pts</td>
                            <td class="py-3 text-black/60">{{ number_format($rp->redeemed) }} pts</td>
                            <td class="py-3 pr-5">
                                @if ($rp->expiring_soon > 0)
                                    <span class="text-warning font-medium">{{ number_format($rp->expiring_soon) }} pts</span>
                                @else
                                    <span class="text-black/25">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-10 text-center text-black/40 text-sm">No enrolled customers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($rewardPoints->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $rewardPoints->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

@endsection
