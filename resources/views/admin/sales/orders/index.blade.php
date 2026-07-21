@extends('admin.catalog.layouts.app')

@section('title', 'All Orders')

@section('content')

    @php $canDeleteOrders = auth()->user()->hasPermission('delete-orders'); @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">All Orders</h1>
            <p class="text-black/45 text-sm mt-1">Track and fulfill customer orders.</p>
        </div>
        <div class="flex items-center gap-2">
            @if ($canDeleteOrders)
                <button type="button" id="deleteSelectedBtn" class="hidden inline-flex items-center gap-2 border border-danger/30 text-danger rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-danger/10 transition">
                    <i class="fa-solid fa-trash text-[10px]"></i> Delete Selected (<span id="selectedCount">0</span>)
                </button>
            @endif
            <a href="{{ route('admin.sales.orders.create') }}" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                <i class="fa-solid fa-plus text-[10px]"></i> Create Order
            </a>
        </div>
    </div>

    <div class="flex gap-2 overflow-x-auto -mx-4 px-4 md:mx-0 md:px-0 mb-5">
        @foreach (['all' => 'All', 'pending' => 'Pending', 'processing' => 'Processing', 'packed' => 'Packed', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled', 'returned' => 'Returned', 'refunded' => 'Refunded'] as $key => $label)
            <a href="{{ route('admin.sales.orders.index', array_filter(request()->except('tab', 'page') + ['tab' => $key])) }}"
               class="shrink-0 text-xs font-semibold px-4 py-2 rounded-full transition {{ $tab === $key ? 'bg-ink text-white' : 'bg-white border border-black/10 hover:bg-black/5' }}">
                {{ $label }} <span class="opacity-70">({{ $counts[$key] }})</span>
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <label for="orderSearch" class="sr-only">Search orders</label>
                <input id="orderSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search by order # or customer..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="payment" aria-label="Filter by payment status" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Payment: All</option>
                    <option value="paid" @selected(request('payment') === 'paid')>Paid</option>
                    <option value="pending" @selected(request('payment') === 'pending')>Pending</option>
                    <option value="refunded" @selected(request('payment') === 'refunded')>Refunded</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[880px]" id="ordersTable">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        @if ($canDeleteOrders)
                            <th class="py-3 pl-5 w-8"><span class="sr-only">Select</span></th>
                        @endif
                        <th class="py-3 font-medium {{ $canDeleteOrders ? '' : 'pl-5' }}">Order</th>
                        <th class="py-3 font-medium">Customer</th>
                        <th class="py-3 font-medium">Items</th>
                        <th class="py-3 font-medium">Payment</th>
                        <th class="py-3 font-medium">Status</th>
                        <th class="py-3 font-medium">Shipping</th>
                        <th class="py-3 font-medium">Date</th>
                        <th class="py-3 font-medium text-right">Total</th>
                        <th class="py-3 pr-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-black/[0.02] transition">
                            @if ($canDeleteOrders)
                                <td class="py-3 pl-5">
                                    <input type="checkbox" class="order-select-checkbox" value="{{ $order->id }}" aria-label="Select order {{ $order->order_number }}">
                                </td>
                            @endif
                            <td class="py-3 font-semibold {{ $canDeleteOrders ? '' : 'pl-5' }}">
                                <a href="{{ route('admin.sales.orders.show', $order) }}" class="hover:text-primary-dark transition">#{{ $order->order_number }}</a>
                            </td>
                            <td class="py-3 text-black/60">{{ $order->customer_name }}</td>
                            <td class="py-3 text-black/60">{{ $order->items_count }}</td>
                            <td class="py-3"><span class="bg-{{ $order->payment_status_color }}/10 text-{{ $order->payment_status_color }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->payment_status) }}</span></td>
                            <td class="py-3">
                                @if (in_array($order->status, ['cancelled', 'returned']))
                                    <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->status) }}</span>
                                @else
                                    <span class="bg-{{ $order->status_color }}/10 text-{{ $order->status_color }} text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-{{ $order->shipping_status_color }}">{{ $order->shipping_status }}</td>
                            <td class="py-3 text-black/50 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="py-3 text-right font-semibold">{{ format_price($order->total) }}</td>
                            <td class="py-3 pr-5 text-right whitespace-nowrap">
                                <a href="{{ route('admin.sales.orders.show', $order) }}" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">View</a>
                                <a href="{{ route('admin.sales.orders.invoice', $order) }}" target="_blank" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">Invoice</a>
                                <a href="{{ route('admin.sales.orders.shipping-label', $order) }}" target="_blank" class="text-xs font-semibold text-black/50 hover:text-ink transition">Label</a>
                                @if ($canDeleteOrders)
                                    <form method="POST" action="{{ route('admin.sales.orders.destroy', $order) }}" class="inline ml-3" onsubmit="return confirm('Delete order #{{ $order->order_number }}? This permanently removes the order and its payment/refund history and cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Delete order {{ $order->order_number }}" class="text-xs font-semibold text-black/50 hover:text-danger transition">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $canDeleteOrders ? 10 : 9 }}" class="py-10 text-center text-black/40 text-sm">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $orders->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

@endsection

@if ($canDeleteOrders)
    @push('scripts')
    <script>
      const ordersTable = document.getElementById('ordersTable');
      const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
      const selectedCountEl = document.getElementById('selectedCount');
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';

      ordersTable.addEventListener('change', (e) => {
        if (!e.target.classList.contains('order-select-checkbox')) return;
        const count = ordersTable.querySelectorAll('.order-select-checkbox:checked').length;
        selectedCountEl.textContent = count;
        deleteSelectedBtn.classList.toggle('hidden', count === 0);
      });

      deleteSelectedBtn.addEventListener('click', async () => {
        const checked = [...ordersTable.querySelectorAll('.order-select-checkbox:checked')];
        if (!checked.length || !confirm(`Delete ${checked.length} selected order(s)? This permanently removes them and their payment/refund history and cannot be undone.`)) return;

        const res = await fetch(@json(route('admin.sales.orders.destroyMany')), {
          method: 'DELETE',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
          body: JSON.stringify({ order_ids: checked.map(c => c.value) }),
        });

        if (!res.ok) { alert('Could not delete the selected orders.'); return; }

        checked.forEach(c => c.closest('tr').remove());
        deleteSelectedBtn.classList.add('hidden');
        selectedCountEl.textContent = '0';
      });
    </script>
    @endpush
@endif
