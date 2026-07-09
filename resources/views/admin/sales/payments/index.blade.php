@extends('admin.catalog.layouts.app')

@section('title', 'Payments')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Payments</h1>
            <p class="text-black/45 text-sm mt-1">Manage payment gateways, transactions, and refunds.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Transactions</p>
            <p class="text-xl font-bold">{{ number_format($stats['total_transactions']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Revenue</p>
            <p class="text-xl font-bold">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Pending Refunds</p>
            <p class="text-xl font-bold text-warning">{{ $stats['pending_refunds'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Failed Payments</p>
            <p class="text-xl font-bold text-danger">{{ $stats['failed_payments'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 mb-6">
        <h2 class="font-bold text-sm mb-4">Payment Gateways</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($gateways as $gateway)
                <div class="border border-black/10 rounded-2xl p-4">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <i class="{{ $gateway->icon_class ?: 'fa-solid fa-credit-card' }} text-xl"></i>
                        <form method="POST" action="{{ route('admin.sales.payments.gateways.update', $gateway) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="is_enabled" value="{{ $gateway->is_enabled ? 0 : 1 }}">
                            <button type="submit" class="relative inline-flex items-center">
                                <span class="w-10 h-6 rounded-full transition {{ $gateway->is_enabled ? 'bg-success' : 'bg-black/10' }} block"></span>
                                <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition {{ $gateway->is_enabled ? 'translate-x-4' : '' }}"></span>
                            </button>
                        </form>
                    </div>
                    <p class="font-semibold text-sm">{{ $gateway->name }}</p>
                    <span class="inline-block mt-1 text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $gateway->is_connected ? 'bg-success/10 text-success' : 'bg-black/5 text-black/45' }}">{{ $gateway->status_label }}</span>
                    <button type="button" class="block w-full mt-3 text-xs font-semibold border border-black/10 rounded-full py-2 text-black/40 cursor-not-allowed" title="No gateway API integration in this pass" disabled>Configure</button>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-card overflow-hidden">
            <div class="p-5 md:p-6 border-b border-black/5">
                <h2 class="font-bold text-sm">Recent Transactions</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[520px]">
                    <thead>
                        <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                            <th class="py-3 pl-5 font-medium">Transaction</th>
                            <th class="py-3 font-medium">Customer</th>
                            <th class="py-3 font-medium">Gateway</th>
                            <th class="py-3 font-medium">Status</th>
                            <th class="py-3 pr-5 font-medium text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5">
                        @forelse ($transactions as $txn)
                            @php $txnColor = ['success' => 'success', 'failed' => 'danger', 'refunded' => 'warning'][$txn->status]; @endphp
                            <tr class="hover:bg-black/[0.02] transition">
                                <td class="py-3 pl-5 font-semibold">{{ $txn->transaction_ref }}</td>
                                <td class="py-3 text-black/60">{{ $txn->order->customer_name ?? '—' }}</td>
                                <td class="py-3 text-black/60">{{ $txn->gateway->name ?? '—' }}</td>
                                <td class="py-3"><span class="bg-{{ $txnColor }}/10 text-{{ $txnColor }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($txn->status) }}</span></td>
                                <td class="py-3 pr-5 text-right font-semibold">${{ number_format($txn->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-8 text-center text-black/40 text-sm">No transactions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($transactions->hasPages())
                <div class="p-4 md:p-5 border-t border-black/5">
                    {{ $transactions->links('admin.catalog.partials.pagination') }}
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Refund Requests</h2>
                @forelse ($refunds as $refund)
                    @php
                        $stages = ['requested', 'approved', 'processed'];
                        $currentIndex = array_search($refund->stage, $stages);
                        $nextStage = $stages[$currentIndex + 1] ?? null;
                    @endphp
                    <div class="mb-5 pb-5 border-b border-black/5 last:border-0 last:mb-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-semibold">Order #{{ $refund->order->order_number ?? '—' }}</p>
                            <p class="text-sm font-semibold">${{ number_format($refund->amount, 2) }}</p>
                        </div>
                        <div class="flex items-center gap-1 mb-2">
                            @foreach ($stages as $i => $stage)
                                <span class="flex-1 h-1.5 rounded-full {{ $i <= $currentIndex ? 'bg-primary-dark' : 'bg-black/10' }}"></span>
                            @endforeach
                        </div>
                        <p class="text-black/40 text-xs mb-2">{{ ucfirst($refund->stage) }}@if($refund->reason) &middot; {{ $refund->reason }}@endif</p>
                        @if ($nextStage)
                            <form method="POST" action="{{ route('admin.sales.refunds.stage', $refund) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="stage" value="{{ $nextStage }}">
                                <button type="submit" class="text-xs font-semibold text-primary-dark hover:text-ink transition">Advance to {{ ucfirst($nextStage) }} &rarr;</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-black/40 text-sm">No refund requests.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Payment Logs</h2>
                <ul class="space-y-3">
                    @forelse ($logs as $log)
                        <li class="flex items-start gap-2.5 text-xs">
                            <span class="w-2 h-2 rounded-full bg-{{ $log['color'] }} mt-1 shrink-0"></span>
                            <div>
                                <p class="text-black/70">{{ $log['text'] }}</p>
                                <p class="text-black/35">{{ $log['at']->diffForHumans() }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="text-black/40 text-sm">No activity yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

@endsection
